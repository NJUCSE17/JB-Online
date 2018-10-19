<?php

namespace App\Models\Forum\Traits\Attribute;

use App\Models\Auth\User;

/**
 * Trait PostAttribute.
 */
trait PostAttribute
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
    public function getAuthorNameLabelAttribute()
    {
        $author = $this->author;
        $authorNameLabel = ($author == null) ? __('labels.general.deleted_data') : $author->name_label;
        return $authorNameLabel;
    }

    /**
     * @return string
     */
    public function getEditorNameLabelAttribute()
    {
        $editor = $this->editor;
        $editorNameLabel = ($editor == null) ? ($this->editor_id . __('labels.general.deleted_data')) : $editor->name_label;
        return $editorNameLabel;
    }

    /**
     * @return string
     */
    public function getEditorNameAttribute()
    {
        $editor = $this->editor;
        $editorName = ($editor == null) ? __('labels.general.deleted_data') : $editor->name;
        return $editorName;
    }

    /**
     * @return string
     */
    public function getTimeLabelAttribute()
    {
        if ($this->created_at != $this->updated_at) {
            return __('labels.general.updated') . ' ' . $this->updated_at->diffForHumans()
                . ' ' . __('labels.general.by') . ' ' .$this->editor_name;
        } else {
            return __('labels.general.published') . ' ' . $this->updated_at->diffForHumans();
        }
    }

    /**
     * @return string
     */
    public function getPostLinkAttribute()
    {
        return "route('frontend.post.view', $this)";
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
     * @return string
     */
    public function getVoteButtonsAttribute()
    {
        return "<a id=\"vote_down_post_" . $this->id . "\" class=\"voteBtn text-" . ($this->isDislikedBy() ? 'danger' : 'dark')
            . "\" href=\"#\" data-pid=\"post_" . $this->id . "\" data-api=\"" . route('frontend.forum.post.votedown', [$this->source->source, $this->source, $this])
            . "\"><i class='far fa-thumbs-down mr-1'></i></a>"

            . "<span id=\"vote_count_label_post_" . $this->id . "\">" . $this->voteCountLabel . "</span>"

            . "<a id=\"vote_up_post_" . $this->id . "\" class=\"voteBtn text-" . ($this->isLikedBy() ? 'success' : 'dark')
            . "\" href=\"#\" data-pid=\"post_" . $this->id . "\" data-api=\"" . route('frontend.forum.post.voteup', [$this->source->source, $this->source, $this])
            . "\"><i class='far fa-thumbs-up ml-1'></i></a>";
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.forum.post.edit', $this)
            .'" data-toggle="tooltip" data-placement="top" title="'
            .__('buttons.general.crud.edit').' '.__('labels.general.post')
            .'" class="btn btn-primary"><i class="far fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.forum.post.destroy', $this).'"
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
        return '<a href="'.route('admin.forum.post.delete-permanently', $this).'" name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.posts.delete_permanently').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="'.route('admin.forum.post.restore', $this).'" name="confirm_item" class="btn btn-info"><i class="fas fa-redo" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.posts.restore_post').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '
				<div class="btn-group" role="group" aria-label="Post Actions">
				  '.$this->restore_button.'
				  '.$this->delete_permanently_button.'
				</div>';
        }

        return '
    	<div class="btn-group" role="group" aria-label="Post Actions">
		  '.$this->edit_button.'
		
		  <div class="btn-group btn-group-sm" role="group">
			<button id="PostActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  More
			</button>
			<div class="dropdown-menu" aria-labelledby="PostActions">
			  '.$this->delete_button.'
			</div>
		  </div>
		</div>';
    }
}
