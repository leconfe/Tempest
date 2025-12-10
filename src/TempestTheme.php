<?php

namespace Tempest;

use App\Classes\Theme;
use App\Facades\Hook;
use App\Forms\Components\TinyEditor;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use App\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Blade;
use luizbills\CSS_Generator\Generator as CSSGenerator;
use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;

class TempestTheme extends Theme
{
    public function boot()
    {
        if (app()->getCurrentScheduledConference()?->getMeta('theme') == 'Tempest') {
            Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/website/components'), prefix: 'website');
            Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/scheduledConference/components'), prefix: 'scheduledConference');
        }
        Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/website/components'), prefix: 'tempest');
    }

    public function getFormSchema(): array
    {
        return [
            Toggle::make('global_navigation')
                ->default(true)
                ->hint('Turn On/Off Global Navigation.'),
            SpatieMediaLibraryFileUpload::make('banner')
                ->collection('tempest-banner')
                ->label('Upload Banner Images')
                ->image()
                ->conversion('thumb-xl')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
            SpatieMediaLibraryFileUpload::make('countdown')
                ->collection('tempest-countdown')
                ->label('Upload Countdown Background')
                ->image()
                ->conversion('thumb-xl')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
            ColorPicker::make('appearance_color')
                ->regex('/^#?(([a-f0-9]{3}){1,2})$/i')
                ->label(__('general.appearance_color')),
            ColorPicker::make('secondary_color')
                ->regex('/^#?(([a-f0-9]{3}){1,2})$/i')
                ->label(__('Secondary Color'))
                ->hint('Secondary color for the border and color for the gradient.'),
            ColorPicker::make('text_color')
                ->regex('/^#?(([a-f0-9]{3}){1,2})$/i')
                ->label(__('Banner Title Color'))
                ->hint('Pick a color for the banner title.'),
            Repeater::make('banner_buttons')
                ->schema([
                    TextInput::make('text')->required(),
                    TextInput::make('url')
                        ->required()
                        ->url(),
                    ColorPicker::make('text_color'),
                    ColorPicker::make('background_color'),
                ])
                ->columns(2),
            Builder::make('layouts')
                ->collapsible()
                ->collapsed()
                ->cloneable()
                ->reorderableWithButtons()
                ->reorderableWithDragAndDrop(true)
                ->blockNumbers(false)
                ->blocks([
                    Builder\Block::make('speakers')
                        ->label('Speakers')
                        ->icon('heroicon-o-users')
                        ->maxItems(1),
                    Builder\Block::make('committees')
                        ->label('Committees')
                        ->icon('heroicon-o-users')
                        ->maxItems(1),
                    Builder\Block::make('sponsors')
                        ->label('Sponsors')
                        ->icon('heroicon-o-building-office-2')
                        ->maxItems(1),
                    Builder\Block::make('partners')
                        ->label('Partners')
                        ->icon('heroicon-o-building-office')
                        ->maxItems(1),
                    Builder\Block::make('latest-news')
                        ->label('Latest News')
                        ->icon('heroicon-o-newspaper')
                        ->maxItems(1),
                    Builder\Block::make('layouts')
                        ->label('Custom Content')
                        ->icon('heroicon-m-bars-3-bottom-left')
                        ->schema([
                            TextInput::make('name_content')
                                ->label('Title')
                                ->required(),
                            TinyEditor::make('about')
                                ->label('Content')
                                ->profile('advanced')
                                ->required(),
                        ]),

                ]),

        ];
    }

    public function onActivate(): void
    {
        Hook::add('Frontend::Views::Head', function ($hookName, &$output) {
            $output .= '<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>';
            $output .= '<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />';

            $cssTempest = $this->url('Tempest.css');
            $output .= "<link rel='stylesheet' type='text/css' href='$cssTempest'>";

            $cssGenerator = new CSSGenerator;

            if ($appearanceColor = $this->getSetting('appearance_color')) {
                $oklch = ColorFactory::new($appearanceColor)->to(ColorSpace::OkLch);
                $cssGenerator = new CSSGenerator;

                $cssGenerator->root_variable('primary-color', value: "{$oklch->lightness}% {$oklch->chroma} {$oklch->hue}");
            }

            if ($borderColor = $this->getSetting('secondary_color')) {
                $oklchBorder = ColorFactory::new($borderColor)->to(ColorSpace::OkLch);
                $cssGenerator->root_variable('secondary-color', value: "{$oklchBorder->lightness}% {$oklchBorder->chroma} {$oklchBorder->hue}");
            }

            if ($textColor = $this->getSetting('text_color')) {
                $oklchText = ColorFactory::new($textColor)->to(ColorSpace::OkLch);
                $cssGenerator->root_variable('text-color', value: "{$oklchText->lightness}% {$oklchText->chroma} {$oklchText->hue}");
            }

            $oklch = ColorFactory::new('#1F2937')->to(ColorSpace::OkLch);
            $cssGenerator->root_variable('bc', "{$oklch->lightness}% {$oklch->chroma} {$oklch->hue}");

            $output .= <<<HTML
            <style>
                {$cssGenerator->get_output()}
            </style>
        HTML;
        });
    }

    public function getFormData(): array
    {
        $banner = $this->getSetting('banner');

        if (is_string($banner) && ! empty($banner)) {
            $banner = [$banner];
        } elseif (! is_array($banner)) {
            $banner = [];
        }

        $countdown = $this->getSetting('countdown');

        if (is_string($countdown) && ! empty($countdown)) {
            $countdown = [$countdown];
        } elseif (! is_array($countdown)) {
            $countdown = [];
        }

        return [
            'banner' => $banner,
            'countdown' => $countdown,
            'layouts' => $this->getSetting('layouts') ?? [],
            'appearance_color' => $this->getSetting('appearance_color'),
            'secondary_color' => $this->getSetting('secondary_color'),
            'text_color' => $this->getSetting('text_color'),
            'button_first' => $this->getSetting('button_first'),
            'button_second' => $this->getSetting('button_second'),
            'button_first_text' => $this->getSetting('button_first_text'),
            'button_second_text' => $this->getSetting('button_second_text'),
            'global_navigation' => $this->getSetting('global_navigation'),
            'banner_buttons' => $this->getSetting('banner_buttons') ?? [],
        ];
    }
}
