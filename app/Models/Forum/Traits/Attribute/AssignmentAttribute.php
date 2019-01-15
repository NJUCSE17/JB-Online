<?php

namespace App\Models\Forum\Traits\Attribute;

use Illuminate\Support\Facades\DB;

/**
 * Trait AssignmentAttribute.
 */
trait AssignmentAttribute
{
    /**
     * @return bool
     */
    public function isPersonal()
    {
        return $this->course_id == 0;
    }

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
    public function getCourseNameAttribute()
    {
        $course = $this->source;
        return ($course == null) ? __('labels.general.personal_data') : $course->name;
    }

    /**
     * @return string
     */
    public function getCourseNameLabelAttribute()
    {
        $course = $this->source;
        $courseNameLabel = ($course == null) ? ("PA - " . __('labels.general.personal_data')) : $course->name_label;
        return $courseNameLabel;
    }

    /**
     * @return string
     */
    public function getAssignmentLinkAttribute()
    {
        if ($this->isPersonal()) {
            return route('frontend.forum.personal.edit', [$this->id]);
        } else {
            return route('frontend.forum.assignment.view', [$this->source, $this, 'asc']);
        }
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
    public function getDDLContentAttribute()
    {
        $finishStatus = $this->finish_status;
        if ($finishStatus == null) {
            return $this->due_time->isoFormat("Y-MM-DD (ddd) H:mm:ss") . ",&nbsp;"
                . $this->due_time->diffForHumans(null, null, false, 2);
        } else {
            return "<s>" . $this->due_time->isoFormat("Y-MM-DD (ddd) H:mm:ss") . ",&nbsp;"
                . $this->due_time->diffForHumans(null, null, false, 2)
                . "</s> &nbsp;" . __('strings.frontend.home.finished_at')
                . $finishStatus->finished_at;
        }
    }

    /**
     * @return string
     */
    public function getFinishLinkAttribute()
    {
        if ($this->issuer == 0) {
            return route('frontend.forum.assignment.finish', [$this->source, $this]);
        } else {
            return route('frontend.forum.personal.finish', [$this]);
        }
    }

    public function getResetLinkAttribute()
    {
        if ($this->issuer == 0) {
            return route('frontend.forum.assignment.reset', [$this->source, $this]);
        } else {
            return route('frontend.forum.personal.reset', [$this]);
        }
    }

    /**
     * @return string
     */
    public function getDDLButtonAttribute()
    {
        $finishStatus = $this->finish_status;
        if ($finishStatus == null) {
            return "<a class=\"btn btn-sm btn-outline-" . $this->ddl_color . " ddlBtn"
                . "\" id=\"assignment_ddl_" . $this->id . "\" data-aid=\""
                . $this->id . "\"" . " data-api=\"" . $this->finish_link
                . "\" href='#'><i class='fas fa-times mr-2'></i>"
                . __('buttons.frontend.forum.assignment.unfinished') . "</a>";
        } else {
            return "<a class=\"btn btn-sm btn-outline-success ddlBtn"
                . "\" id=\"assignment_ddl_" . $this->id . "\" data-aid=\""
                . $this->id . "\"" . " data-api=\"" . $this->reset_link
                . "\" href='#'><i class='fas fa-check mr-2'></i>"
                . __('buttons.frontend.forum.assignment.finished') . "</a>";
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
    public function getFinishStatusAttribute()
    {
        return DB::table('assignment_finish_records')
            ->where('assignment_id', '=', $this->id)
            ->where('user_id', '=', \Auth::id())
            ->first();
    }

    /**
     * @return bool
     */
    public function getIsFinishedAttribute()
    {
        return $this->finish_status != NULL;
    }

    /**
     * @return mixed
     */
    public function getProblemsTableAttribute()
    {
        if ($this->problems->count()) {
            $table = "<table id=\"problemset\" class=\"table table-bordered table-hover table-sm\" 
                        style=\"text-align: center; width: 90%; margin-left: auto; margin-right: auto;\" 
                        width=\"90%\"> <tbody>";
            foreach ($this->problems as $problem) {
                $table = $table . "<tr><td>" . $problem->content . "</td><td>" . $problem->vote_buttons . "</td></tr>";
            }
            $table = $table . "</tbody> </table>";
            return $table;
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        if ($this->isPersonal()) {
            return '<a href="' . route('frontend.forum.personal.edit', $this)
                . '" data-toggle="tooltip" data-placement="top" title="'
                . __('buttons.general.crud.edit') . ' ' . __('labels.general.assignment')
                . '" class="btn btn-primary"><i class="far fa-edit"></i></a>';
        } else {
            return '<a href="' . route('admin.forum.assignment.edit', $this)
                . '" data-toggle="tooltip" data-placement="top" title="'
                . __('buttons.general.crud.edit') . ' ' . __('labels.general.assignment')
                . '" class="btn btn-primary"><i class="far fa-edit"></i></a>';
        }
    }

    /**
     * @return string
     */
    public function getProblemButtonAttribute()
    {
        return '<a href="' . route('admin.forum.problem.specific', $this)
            . '" data-toggle="tooltip" data-placement="top" title="'
            . __('buttons.general.crud.edit') . ' ' . __('labels.general.problem')
            . '" class="btn btn-success"><i class="far fa-lightbulb"></i></a>';
    }

    /**
     * @return string
     */
    public function getPostButtonAttribute()
    {
        return '<a href="' . route('admin.forum.post.specific', $this)
            . '" data-toggle="tooltip" data-placement="top" title="'
            . __('buttons.general.crud.edit') . ' ' . __('labels.general.post')
            . '" class="btn btn-warning text-white"><i class="far fa-comments"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        if ($this->isPersonal()) {
            return '<a href="' . route('frontend.forum.personal.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="dropdown-item">' . __('buttons.general.crud.delete') . '</a> ';
        } else {
            return '<a href="' . route('admin.forum.assignment.destroy', $this) . '"
                 data-method="delete"
                 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
                 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
                 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
                 class="dropdown-item">' . __('buttons.general.crud.delete') . '</a> ';
        }
    }

    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        if ($this->isPersonal()) {
            return '<a href="' . route('frontend.forum.personal.delete-permanently', $this)
                . '" name="confirm_item" class="btn btn-danger">'
                . '<i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'
                . __('buttons.general.crud.delete_permanently') . '"></i></a> ';
        } else {
            return '<a href="' . route('admin.forum.assignment.delete-permanently', $this)
                . '" name="confirm_item" class="btn btn-danger">'
                . '<i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="'
                . __('buttons.general.crud.delete_permanently') . '"></i></a> ';
        }
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        if ($this->isPersonal()) {
            return '<a href="' . route('frontend.forum.personal.restore', $this)
                . '" name="confirm_item" class="btn btn-info">'
                . '<i class="fas fa-redo" data-toggle="tooltip" data-placement="top" title="'
                . __('buttons.general.crud.restore') . '"></i></a> ';
        } else {
            return '<a href="' . route('admin.forum.assignment.restore', $this)
                . '" name="confirm_item" class="btn btn-info">'
                . '<i class="fas fa-redo" data-toggle="tooltip" data-placement="top" title="'
                . __('buttons.general.crud.restore') . '"></i></a> ';
        }
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
		  ' . $this->edit_button . ($this->isPersonal() ? '' : ($this->problem_button . $this->post_button)) . '
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
