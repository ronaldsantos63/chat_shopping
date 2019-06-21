<?php
declare(strict_types=1);

namespace ChatShopping\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class ProductPhoto extends Model
{
    const BASE_PATH = 'app/public';
    const DIR_PRODUCTS = 'products';

    const PRODUCTS_PATH = self::BASE_PATH . '/' . self::DIR_PRODUCTS;

    protected $fillable = ['file_name', 'product_id'];

    public static function photosPath(int $productId)
    {
        $path = self::PRODUCTS_PATH;
        return storage_path("{$path}/{$productId}");
    }

    public static function createWithPhotosFiles(int $productId, array $files): Collection
    {
        try {
            self::uploadFiles($productId, $files);
            \DB::beginTransaction();
            $photos = self::createPhotosModels($productId, $files);
            \DB::commit();
            return new Collection($photos);
        } catch (\Exception $e) {
            self::deleteFiles($productId, $files);
            \DB::rollBack();
            throw $e;
        }
    }

    public static function deleteWithPhotoFile(int $productId, ProductPhoto $photo)
    {
        self::deleteFile($productId, $photo->file_name);
        $photo->delete();
    }

    public static function updateWithPhotoFile(int $productId, ProductPhoto $photo, UploadedFile $file): ProductPhoto
    {
        $bkpPhotoPath = self::backupPhoto($productId, $photo->file_name);
        $oldPhotoName = $photo->file_name;
        try {
            self::uploadFiles($productId, [$file]);
            \DB::beginTransaction();
            self::deleteFile($productId, $oldPhotoName);
            $photo->file_name = $file->hashName();
            $photo->save();
            \DB::commit();
            return $photo;
        } catch (\Exception $e) {
            self::deleteFiles($productId, [$file]);
            self::restorePhoto($bkpPhotoPath, $productId, $oldPhotoName);
            \DB::rollBack();
            throw $e;
        }
    }

    private static function backupPhoto(int $productId, string $fileName) : string
    {
        $path = self::photosPath($productId);
        $photoPath = "{$path}/{$fileName}";
        $temp_file = sys_get_temp_dir() . "\{$fileName}";
        \File::copy($photoPath, $temp_file);
        return $temp_file;
    }

    private static function restorePhoto(string $temp_file, int $productId, string $fileName)
    {
        try {
            $path = self::photosPath($productId);
            $photoPath = "{$path}/{$fileName}";
            \File::copy($temp_file, $photoPath);
            \File::delete($temp_file);
        } catch (\Exception $e){

        }
    }

    private static function deleteFile(int $productId, string $fileName)
    {
        $path = self::photosPath($productId);
        $photoPath = "{$path}/{$fileName}";
        if (file_exists($photoPath)) {
            \File::delete($photoPath);
        }
    }

    private static function deleteFiles(int $productId, array $files)
    {

        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $path = self::photosPath($productId);
            $photoPath = "{$path}/{$file->hashName()}";
            if (file_exists($photoPath)) {
                \File::delete($photoPath);
            }
        }
    }

    public static function uploadFiles(int $productId, array $files)
    {
        $dir = self::photosDir($productId);
        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $file->store($dir, ['disk' => 'public']);
        }
    }

    private static function createPhotosModels(int $productId, array $files): array
    {
        $photos = [];
        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $photos[] = self::create([
                'file_name' => $file->hashName(),
                'product_id' => $productId
            ]);
        }
        return $photos;
    }

    public function getPhotoUrlAttribute()
    {
        $path = self::photosDir($this->product_id);
        return asset("storage/{$path}/{$this->file_name}");
    }

    public static function photosDir(int $productId)
    {
        $dir = self::DIR_PRODUCTS;
        return "{$dir}/{$productId}";
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
