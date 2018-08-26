<?php

namespace App\Models\Forum\Traits\Attribute;

/**
 * Trait CourseAttribute.
 */
trait CourseAttribute
{
    /**
     * @return string
     */
    public function getNameLabelAttribute()
    {
        return $this->id .' (' .$this->name . ')';
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $today = date("Y-m-d H:i:s");
        if ($today < $this->start_time) {
            return "<span class='badge badge-warning'>" .
                __('labels.frontend.forum.courses.status.pending') . '</span>';
        }

        if ($today > $this->end_time) {
            return "<span class='badge badge-dark'>".
                __('labels.frontend.forum.courses.status.ended') .'</span>';
        }

        return "<span class='badge badge-success'>" .
            __('labels.frontend.forum.courses.status.ongoing') . '</span>';
    }

    /**
     * @return string
     */
    public function getDifficultyLabelAttribute()
    {
        if ($this->difficulty == 0) {
            return "<span class='badge badge-success'>" .
                __('labels.frontend.forum.courses.difficulty.easy') . '</span>';
        }

        if ($this->difficulty == 1) {
            return "<span class='badge badge-warning'>" .
                __('labels.frontend.forum.courses.difficulty.medium') . '</span>';
        }

        if ($this->difficulty == 2) {
            return "<span class='badge badge-danger'>" .
                __('labels.frontend.forum.courses.difficulty.hard') . '</span>';
        }

        return "<span class='badge badge-dark'>" .
            __('labels.frontend.forum.courses.difficulty.insane') .'</span>';
    }

    /**
     * @return string
     */
    public function getRestrictLabelAttribute()
    {
        if ($this->restrict_level == 0) {
            return "<span class='badge badge-success'>" .
                __('labels.frontend.forum.courses.restriction.free') . '</span>';
        }

        if ($this->restrict_level == 1) {
            return "<span class='badge badge-warning'>" .
                __('labels.frontend.forum.courses.restriction.restricted') .'</span>';
        }

        return "<span class='badge badge-danger'>" .
            __('labels.frontend.forum.courses.restriction.forbidden') . '</span>';
    }

    /**
     * @return string
     */
    public function getLabelsAttribute()
    {
        return $this->getStatusLabelAttribute();
        /*
        return $this->getStatusLabelAttribute() . " "
            . $this->getDifficultyLabelAttribute() . " "
            . $this->getRestrictLabelAttribute();
        */
    }

    /**
     * @return string
     */
    public function getCourseLinkAttribute()
    {
        return route('frontend.forum.course.view', $this);
    }

    /**
     * @return string
     */
    public function getAuthorNameAttribute()
    {
        $author = $this->author;
        $authorName = ($author == null) ? __('labels.general.deleted_data') : $author->name;
        return $authorName;
    }

    /**
     * @return string
     */
    public function getTimeLabelAttribute()
    {
        return __('labels.general.updated') . ' ' . $this->updated_at->diffForHumans()
                . ' ' . __('labels.general.by') . ' ' .$this->author_name;
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.forum.course.edit', $this)
            .'" data-toggle="tooltip" data-placement="top" title="'
            .__('buttons.general.crud.edit').' '.__('labels.general.course')
            .'" class="btn btn-primary"><i class="far fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getAssignmentButtonAttribute()
    {
        return '<a href="'.route('admin.forum.assignment.specific', $this)
            .'" data-toggle="tooltip" data-placement="top" title="'
            .__('buttons.general.crud.edit').' '.__('labels.general.assignment')
            .'" class="btn btn-warning"><i class="far fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.forum.course.destroy', $this).'"
                 data-method="delete"
                 data-trans-button-cancel="'.__('buttons.general.cancel').'"
                 data-trans-button-confirm="'.__('buttons.general.crud.delete').'"
                 data-trans-title="'.__('strings.backend.general.are_you_sure').'"
                 class="dropdown-item">'.__('buttons.general.crud.delete').'</a> ';
    }

    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="'.route('admin.forum.course.delete-permanently', $this).'" name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.Courses.delete_permanently').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="'.route('admin.forum.course.restore', $this).'" name="confirm_item" class="btn btn-info"><i class="fas fa-redo" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.Courses.restore_Course').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '
				<div class="btn-group" role="group" aria-label="Course Actions">
				  '.$this->restore_button.'
				  '.$this->delete_permanently_button.'
				</div>';
        }

        return '
    	<div class="btn-group" role="group" aria-label="Course Actions">
		  '.$this->edit_button.'
		  '.$this->assignment_button.'
		
		  <div class="btn-group btn-group-sm" role="group">
			<button id="CourseActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  More
			</button>
			<div class="dropdown-menu" aria-labelledby="CourseActions">
			  '.$this->delete_button.'
			</div>
		  </div>
		</div>';
    }
}
