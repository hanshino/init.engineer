<?php

namespace App\Domains\Companie\Models;

use App\Domains\Companie\Models\Traits\Relationship\CompanieJobsRelationship;
use App\Models\Traits\Picture;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CompanieJobs.
 */
class CompanieJobs extends Model
{
    use SoftDeletes,
        CompanieJobsRelationship,
        Picture,
        Uuid;

    /**
     * 職缺類型: 全職
     *
     * @var string
     */
    public const JOB_FULL_TIME = 'Full-time job';

    /**
     * 職缺類型: 兼職
     *
     * @var string
     */
    public const JOB_PART_TIME = 'Part-time job';

    /**
     * 職缺類型: 派遣
     *
     * @var string
     */
    public const JOB_DISPATCHED = 'Dispatched labor';

    /**
     * 職缺類型: 實習
     *
     * @var string
     */
    public const JOB_INTERNSHIP = 'Internship';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companie_jobs';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'companie_id',
        'name',
        'type',
        'content',
        'pay',
        'active',
        'blockade',
        'blockade_by',
        'blockade_remarks',
        'blockade_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'json',
        'pay' => 'json',
        'active' => 'boolean',
        'blockade' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'blockade_at',
    ];
}
