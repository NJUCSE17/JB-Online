<?php

namespace App\Models\Forum\Traits\Attribute;

use Illuminate\Support\Facades\DB;

/**
 * Trait AssignmentAttribute.
 */
trait AssignmentAttribute
{
    /**
     * @return string
     */
    public function getNameLabelAttribute()
    {
        return $this->id . ' (' . $this->name . ')';
    }

    /**
     * @return string
     */
    public function getCourseNameLabelAttribute()
    {
        $course = $this->source;
        $courseNameLabel = ($course == null) ? __('labels.general.deleted_data') : $course->name_label;
        return $courseNameLabel;
    }

    /**
     * @return string
     */
    public function getAssignmentLinkAttribute()
    {
        return route('frontend.forum.assignment.view', [$this->source, $this, 'asc']);
    }

    /**
     * @return string
     */
    public function getLabelColorAttribute()
    {
        if ($this->ongoing) {
            return 'success';
        } else {
            return 'primary';
        }
    }

    /**
     * @return string
     */
    public function getDDLColorAttribute()
    {
        $delta = $this->due_time->diffInDays();
        if ($delta < 1) {
            return "danger";
        } elseif ($delta < 2) {
            return "warning";
        } else if ($delta < 5) {
            return "info";
        } else {
            return "secondary";
        }
    }

    /**
     * @return string
     */
    public function getDDLBadgeContentAttribute()
    {
        return  $this->due_time->isoFormat("Y-MM-DD (ddd) H:mm:ss") . "<br />"
            . $this->due_time->diffForHumans(null, null, false, 2);
    }

    /**
     * @return string
     */
    public function getDDLBadgeAttribute()
    {
        $finishStatus = $this->finish_status;
        $assignmentContent = preg_replace("/<a.*>.*<\/a>/", "--", $this->content);
        $assignmentContent = preg_replace("/style=\".*\"/", "", $assignmentContent);
        if ($finishStatus == null) {
            $content = $this->ddl_badge_content;
            return "<a class=\"btn btn-sm btn-outline-" . $this->ddl_color . " finishBtn"
                . "\" id=\"assignment_ddl\" data-name=\"" . $this->name . "\" data-content=\"" . $assignmentContent
                . "\"" . "href='" . route('frontend.forum.assignment.finish', [$this->source, $this])
                . "'>" . $content . "</a>";
        } else {
            $content = "<i class='fas fa-check mr-2'></i>" . $finishStatus->finished_at;
            return "<a class=\"btn btn-sm btn-outline-success resetBtn" . "\" id=\"assignment_ddl\" data-name=\""
                . $this->name . "\" data-content=\"" . $assignmentContent . "\" data-ddl=\"" . $this->ddl_badge_content
                . "\"" . "href='" . route('frontend.forum.assignment.reset', [$this->source, $this])
                . "'>" . $content . "</a>";
        }
    }

    /**
     * @return bool
     */
    public function getOngoingAttribute()
    {
        $today = date("Y-m-d H:i:s");
        return $today < $this->due_time;
    }

    /**
     * @return mixed
     */
    public function getFinishStatusAttribute() {
        return DB::table('assignment_finish_records')
            ->where('assignment_id', '=', $this->id)
            ->where('user_id','=', \Auth::id())
            ->first();
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.forum.assignment.edit', $this)
            . '" data-toggle="tooltip" data-placement="top" title="'
            . __('buttons.general.crud.edit') . ' ' . __('labels.general.assignment')
            . '" class="btn btn-primary"><i class="far fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getPostButtonAttribute()
    {
        return '<a href="' . route('admin.forum.post.specific', $this)
            . '" data-toggle="tooltip" data-placement="top" title="'
            . __('buttons.general.crud.edit') . ' ' . __('labels.general.post')
            . '" class="btn btn-warning"><i class="far fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.forum.assignment.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="dropdown-item">' . __('buttons.general.crud.delete') . '</a> ';
    }

    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="' . route('admin.forum.assignment.delete-permanently', $this) . '" name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.access.Assignments.delete_permanently') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="' . route('admin.forum.assignment.restore', $this) . '" name="confirm_item" class="btn btn-info"><i class="fas fa-redo" data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.access.Assignments.restore_Assignment') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '
				<div class="btn-group" role="group" aria-label="Assignment Actions">
				  ' . $this->restore_button . '
				  ' . $this->delete_permanently_button . '
				</div>';
        }

        return '
    	<div class="btn-group" role="group" aria-label="Assignment Actions">
		  ' . $this->edit_button . '
		  ' . $this->post_button . '
		
		  <div class="btn-group btn-group-sm" role="group">
			<button id="AssignmentActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  More
			</button>
			<div class="dropdown-menu" aria-labelledby="AssignmentActions">
			  ' . $this->delete_button . '
			</div>
		  </div>
		</div>';
    }
}
