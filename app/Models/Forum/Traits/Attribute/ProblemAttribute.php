<?php

namespace App\Models\Forum\Traits\Attribute;

use App\Models\Auth\User;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Trait ProblemAttribute.
 */
trait ProblemAttribute
{
    /**
     * @return string
     */
    public function getCourseNameLabelAttribute()
    {

        $assignment = $this->source;
        $courseNameLabel = ($assignment == null) ? __('labels.general.deleted_data') : $assignment->course_name_label;
        return $courseNameLabel;
    }

    /**
     * @return string
     */
    public function getAssignmentNameLabelAttribute()
    {
        $assignment = $this->source;
        $assignmentNameLabel = ($assignment == null) ? __('labels.general.deleted_data') : $assignment->name_label;
        return $assignmentNameLabel;
    }

    /**
     * @return string
     */
    public function getContentDisplayAttribute()
    {
        if ($this->permalink != null) {
            return "<a href=\"" . $this->permalink . "\">" . $this->content . "</a>";
        } else {
            return $this->content;
        }
    }

    /**
     * @return String
     */
    public function getVoteCountLabelAttribute() {
        $voteStatus = $this->isLikedBy() ? 1 : ($this->isDislikedBy() ? -1 : 0);
        return ($this->likesDiffDislikesCount > 0 ? "+" : "") . $this->likesDiffDislikesCount
            . " (" . ($this->likesCount + $this->dislikesCount) . ")";
    }

    /**
     * @return String
     */
    public function getVoteButtonsAttribute()
    {
        return "<a id=\"vote_down_" . $this->id . "\" class=\"voteBtn text-" . ($this->isDislikedBy() ? 'danger' : 'dark')
            . "\" href=\"#\" data-pid=\"" . $this->id . "\" data-api=\"" . route('frontend.forum.problem.votedown', [$this->source->source, $this->source, $this])
            . "\"><i class='far fa-thumbs-down mr-1'></i></a>"

            . "<span id=\"vote_count_label_" . $this->id . "\">" . $this->voteCountLabel . "</span>"

            . "<a id=\"vote_up_" . $this->id . "\" class=\"voteBtn text-" . ($this->isLikedBy() ? 'success' : 'dark')
            . "\" href=\"#\" data-pid=\"" . $this->id . "\" data-api=\"" . route('frontend.forum.problem.voteup', [$this->source->source, $this->source, $this])
            . "\"><i class='far fa-thumbs-up ml-1'></i></a>";
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.forum.problem.edit', $this)
            .'" data-toggle="tooltip" data-placement="top" title="'
            .__('buttons.general.crud.edit').' '.__('labels.general.problem')
            .'" class="btn btn-primary"><i class="far fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.forum.problem.destroy', $this).'"
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
        return '<a href="'.route('admin.forum.problem.delete-permanently', $this).'" name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.problems.delete_permanently').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="'.route('admin.forum.problem.restore', $this).'" name="confirm_item" class="btn btn-info"><i class="fas fa-redo" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.problems.restore_problem').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '
				<div class="btn-group" role="group" aria-label="Problem Actions">
				  '.$this->restore_button.'
				  '.$this->delete_permanently_button.'
				</div>';
        }

        return '
    	<div class="btn-group" role="group" aria-label="Problem Actions">
		  '.$this->edit_button.'
		
		  <div class="btn-group btn-group-sm" role="group">
			<button id="ProblemActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  More
			</button>
			<div class="dropdown-menu" aria-labelledby="ProblemActions">
			  '.$this->delete_button.'
			</div>
		  </div>
		</div>';
    }
}
