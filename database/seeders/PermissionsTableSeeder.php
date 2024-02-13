<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use Spatie\Permission\Models\Permission;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws ReflectionException
     */
    public function run()
    {
        /**
         * This code automatically identified constants declared on models and build the list of permissions.
         * Constant name should start with "PERMISSION_" and value can be anything non-conflicting with other permissions.
         * See User model for example.
         */
        $models = collect(File::allFiles(app_path('Models')))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                return sprintf('\%s%s',
                    Container::getInstance()->getNamespace().'Models\\',
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));
            })
            ->filter(function ($class) {
                $valid = false;
                if (class_exists($class)) {
                    $reflection = new ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }

                return $valid;
            });

        $processed = [];
        foreach ($models as $model) {
            $reflection = new ReflectionClass($model);
            $constants = $reflection->getConstants();
            foreach ($constants as $constant => $value) {
                if (Str::startsWith($constant, 'PERMISSION_')) {
                    $permission = Permission::query()->updateOrCreate(['name' => $value, 'guard_name' => 'admin'],
                        ['group' => class_basename($model)]);
                    $processed[] = $permission->getKey();
                }

                /**
                 * Note: In case have to introduce permissions for another guard,
                 * add another if condition check here accordingly.
                 *
                 * eg: if (Str::startsWith($constant, 'GUARD_PERMISSION_'))
                 *
                 * And add corresponding constants on model.
                 */
            }
        }

        //Remove stray permissions if any
        Permission::query()->whereNotIn((new Permission())->getKeyName(), $processed)->delete();
    }
}
