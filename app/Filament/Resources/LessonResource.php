<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use App\Models\Module;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('module_id')
                    ->relationship('module', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                        if ($operation !== 'create') {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    }),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),

                Forms\Components\Textarea::make('summary')
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_premium')
                    ->required(),

                // Listening Section
                Forms\Components\Section::make('Listening Section')
                    ->schema([
                        Forms\Components\FileUpload::make('listening_audio_path')
                            ->required()
                            ->directory('lessons/audio')
                            ->acceptedFileTypes([
                                'audio/mp4',
                                'audio/x-m4a',
                                'audio/m4a',
                                'audio/mpeg',
                                'audio/wav',
                                'audio/mp3'
                            ])
                            ->maxSize(10240), // 10MB

                        Forms\Components\RichEditor::make('listening_transcript')
                            ->columnSpanFull(),
                    ]),

                // Reading Section
                Forms\Components\Section::make('Reading Section')
                    ->schema([
                        Forms\Components\RichEditor::make('reading_content')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('reading_vocabulary')
                            ->schema([
                                Forms\Components\TextInput::make('term')->required(),
                                Forms\Components\TextInput::make('definition')->required(),
                            ])
                            ->columnSpanFull()
                            ->grid(2),
                    ]),

                // Quiz Questions Section
                Forms\Components\Repeater::make('quizQuestions')
                    ->label('Quiz Questions')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->required()
                            ->default(0),

                        Forms\Components\Textarea::make('question')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\KeyValue::make('options')
                            ->keyLabel('Option Key (A,B,C,D)')
                            ->valueLabel('Option Text')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('correct_index')
                            ->label('Correct Answer')
                            ->options(fn($get) => collect($get('options') ?? [])
                                ->mapWithKeys(fn($v, $k) => [$k => $v]))
                            ->required(),

                        Forms\Components\Textarea::make('explanation')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->defaultItems(8)
                    // ->minItems(8)
                    ->maxItems(2)
                    ->collapsible()
                    ->itemLabel(fn(array $state): ?string => $state['question'] ?? null)

                    ->collapsible(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module.title')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_premium')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('module')
                    ->relationship('module', 'title'),
                Tables\Filters\TernaryFilter::make('is_premium'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('module_id', 'asc')
            ->groups([
                Tables\Grouping\Group::make('module.title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
