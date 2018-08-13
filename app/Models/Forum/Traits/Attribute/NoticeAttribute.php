<?php

namespace App\Models\Forum\Traits\Attribute;

/**
 * Trait NoticeAttribute.
 */
trait NoticeAttribute
{
    /**
     * @return string
     */
    public function getAuthorNameAttribute()
    {
        $author = $this->author;
        $authorName = ($author == null) ? '(deleted)' : $author->name;
        return $authorName;
    }

    /**
     * @return string
     */
    public function getTimeLabelAttribute()
    {
        return __('labels.general.published') . ' '
            . $this->updated_at->diffForHumans()
            . ' ' . __('by') . ' ' .$this->author_name;
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.forum.notice.edit', $this)
            .'" data-toggle="tooltip" data-placement="top" title="'
            .__('buttons.general.crud.edit').' '.__('labels.general.notice')
            .'" class="btn btn-primary"><i class="far fa-edit"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.forum.notice.destroy', $this).'"
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
        return '<a href="'.route('admin.forum.notice.delete-permanently', $this).'" name="confirm_item" class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.Notices.delete_permanently').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="'.route('admin.forum.notice.restore', $this).'" name="confirm_item" class="btn btn-info"><i class="fas fa-redo" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.access.Notices.restore_Notice').'"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '
				<div class="btn-group" role="group" aria-label="Notice Actions">
				  '.$this->restore_button.'
				  '.$this->delete_permanently_button.'
				</div>';
        }

        return '
    	<div class="btn-group" role="group" aria-label="Notice Actions">
		  '.$this->edit_button.'
		
		  <div class="btn-group btn-group-sm" role="group">
			<button id="NoticeActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  More
			</button>
			<div class="dropdown-menu" aria-labelledby="NoticeActions">
			  '.$this->delete_button.'
			</div>
		  </div>
		</div>';
    }
}
