<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;

class Post extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'author_id', 'category_id', 'title', 'slug', 'excerpt', 'body', 'image', 'view_count', 'published_at', 'meta_description'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * The model's default values for attributes.
     * @var array
     */
    protected $attributes = [
        'image' => 'default_post_image.jpg'
    ];

    /**
     * Get the user that owns the post.
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the post.
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tags that owns the post.
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the comments that owns the post.
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param string $label
     * @return string
     */
    public function commentsNumber($label = 'Comment')
    {
        $commentsNumber = ($tmp = $this->comments) ? $tmp->count() : 0;

        return $commentsNumber . " " . str_plural($label, $commentsNumber);
    }

    /**
     * @param string $label
     * @return string
     */
    public function viewsNumber($label = 'View')
    {
        $viewsNumber = $this->view_count;

        return $viewsNumber . " " . str_plural($label, $viewsNumber);
    }

    /**
     * @param array $data
     */
    public function createComment(array $data)
    {
        $this->comments()->create($data);
    }

    /**
     * @param $str
     */
    public function createTags($str)
    {
        $tags = explode(",", $str);
        $tagIds = [];

        foreach ($tags as $tag) {
            $newTag = Tag::firstOrCreate([
                'slug' => str_slug($tag),
                'name' => ucwords(trim($tag))
            ]);

            $tagIds[] = $newTag->id;
        }

        $this->tags()->sync($tagIds);
    }

    /**
     * Set the publish date to null if will be empty.
     * @param  string  $value
     * @return void
     */
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ?: NULL;
    }

    /**
     * @return mixed
     */
    public function getTagsListAttribute()
    {
        return $this->tags->pluck('name');
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageUrlAttribute($value)
    {
        $imageUrl = "";

//        if ( ! is_null($this->image)) {
//            $directory = config('cms.image.post_image_directory');
//            $imagePath = storage_path() . "/{$directory}/" . $this->image;
//
//            if (file_exists($imagePath)) $imageUrl = url('storage/post_images/'. $this->image);
//        }
        $directory = config('cms.image.post_image_directory');
        $imagePath = storage_path() . "/{$directory}/" . $this->image;

        if (file_exists($imagePath)) $imageUrl = url('storage/post_images/'. $this->image);

        return $imageUrl;
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageThumbUrlAttribute($value)
    {
        $imageUrl = "";

//        if ( ! is_null($this->image)) {
//            $directory = config('cms.image.post_image_directory');
//            $ext       = substr(strrchr($this->image, '.'), 1);
//            $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $this->image);
//            $imagePath = storage_path() . "/{$directory}/" . $thumbnail;
//
//            if (file_exists($imagePath)) $imageUrl = url('storage/post_images/'. $thumbnail );
//        }
        $directory = config('cms.image.post_image_directory');
        $ext       = substr(strrchr($this->image, '.'), 1);
        $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $this->image);
        $imagePath = storage_path() . "/{$directory}/" . $thumbnail;

        if (file_exists($imagePath)) $imageUrl = url('storage/post_images/'. $thumbnail );

        return $imageUrl;
    }

    /**
     * @param $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();
    }

    /**
     * @param $value
     * @return |null
     */
    public function getBodyHtmlAttribute($value)
    {
        return $this->body ? Markdown::convertToHtml(e($this->body)) : NULL;
    }

    /**
     * @param $value
     * @return |null
     */
    public function getExcerptHtmlAttribute($value)
    {
        return $this->excerpt ? Markdown::convertToHtml(e($this->excerpt)) : NULL;
    }

    /**
     * @return string
     */
    public function getTagsHtmlAttribute()
    {
        $anchors = [];
        foreach($this->tags as $tag) {
//            $anchors[] = '<a href="' . route('tag', $tag->slug) . '">' . $tag->name . '</a>';
            $anchors[] = '<a href="#" class="btn btn-default btn-xs">' . $tag->name . '</a>';
        }
        return implode(" ", $anchors);
    }

    /**
     * @param bool $showTimes
     * @return mixed
     */
    public function dateFormatted($showTimes = false)
    {
        $format = "d/m/Y";
        if ($showTimes) $format = $format . " H:i:s";
        return $this->created_at->format($format);
    }

    /**
     * @return string
     */
    public function publicationLabel()
    {
        if ( ! $this->published_at) {
            return '<span class="label label-warning">Draft</span>';
        } elseif ($this->published_at && $this->published_at->isFuture()) {
            return '<span class="label label-info">Schedule</span>';
        } else {
            return '<span class="label label-success">Published</span>';
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where("published_at", "<=", Carbon::now());
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeScheduled($query)
    {
        return $query->where("published_at", ">", Carbon::now());
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDraft($query)
    {
        return $query->whereNull("published_at");
    }

    /**
     * @return mixed
     */
    public static function archives()
    {
        if (env('DB_CONNECTION') == 'pgsql') {
            return static::selectRaw('count(id) as post_count, extract(year from published_at) as year, extract(month from published_at) as month')
                        ->published()
                        ->groupBy('year', 'month')
                        ->orderByRaw('min(published_at) desc')
                        ->get();
        } else {
            return static::selectRaw('count(id) as post_count, year(published_at) year, month(published_at) month')
                        ->published()
                        ->groupBy('year', 'month')
                        ->orderByRaw('min(published_at) desc')
                        ->get();
        }
    }

    /**
     * @param $query
     * @param $filter
     */
    public function scopeFilter($query, $filter)
    {
        if (isset($filter['month']) && $month = $filter['month']) {
            if (env('DB_CONNECTION') == 'pgsql') {
                $query->whereRaw('extract(month from published_at) = ?', [$month]);
            } else {
                $query->whereRaw('month(published_at) = ?', [$month]);
            }
        }

        if (isset($filter['year']) && $year = $filter['year']) {
            if (env('DB_CONNECTION') == 'pgsql') {
                $query->whereRaw('extract(year from published_at) = ?', [$year]);
            } else {
                $query->whereRaw('year(published_at) = ?', [$year]);
            }
        }

        // check if any term entered
        if (isset($filter['term']) && $term = strtolower($filter['term'])) {
            $query->where(function($q) use ($term) {
                // $q->whereHas('author', function($qr) use ($term) {
                //     $qr->where('name', 'LIKE', "%{$term}%");
                // });
                // $q->orWhereHas('category', function($qr) use ($term) {
                //     $qr->where('title', 'LIKE', "%{$term}%");
                // });
                $q->orWhereRaw('LOWER(title) LIKE ?', ["%{$term}%"]);
                $q->orWhereRaw('LOWER(excerpt) LIKE ?', ["%{$term}%"]);
            });
        }
    }
}
