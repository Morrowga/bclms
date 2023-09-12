<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class SystemThemeEloquentModel extends Model
{
    protected $table = 'system_themes';

    protected $fillable = [
        'skins',
        'themes',
        'primary_color',
        'secondary_color',
        'content_with',
        'header_type',
        'footer_type',
        'menu_type',
    ];
}
