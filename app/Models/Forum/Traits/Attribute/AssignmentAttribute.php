<?php

namespace App\Models\Forum\Traits\Attribute;


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
        $delta = $this->due_time->diffInHours(\Carbon\Carbon::now());
        if ($delta <= 24) {
            return "danger";
        } elseif ($delta <= 72) {
            return "warning";
        } else if ($delta <= 168) {
            return "info";
        } else {
            return "secondary";
        }
    }

    /**
     * @return string
     */
    public function getDDLBadgeAttribute()
    {
        return "<a class=\"badge badge-outline-" . $this->ddl_color . "\" id=\"assignment_ddl\""
            . "href='" . $this->assignment_link . "'>"
            . $this->due_time->isoFormat("Y-MM-DD (ddd) H:mm:ss") . "<br />"
            . $this->due_time->diffForHumans(null, null, false, 2) . "</a>";
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
