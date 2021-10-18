<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 画像サイズを指定
        $width = 500;
        $height = random_int(250, 600);
        // 画像を保存してpathを取得
        $file = $this->faker->image(null, $width, $height);
        $path = Storage::putFile('posts', $file);
        File::delete($file);
        return [
            'post_id' => \App\Models\Post::Factory()->create(),
            'org_name' => basename($file),
            'name' => basename($path),
        ];
    }
}
