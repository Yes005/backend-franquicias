<?php
namespace App\Http\Requests\v1;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UserProfileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [$this->requiredIfMethod('POST'), 'string','max:100','min:3'],
            'last_name' => [$this->requiredIfMethod('POST'), 'string','max:100','min:3'],
            'email' => [$this->requiredIfMethod('POST'), 'email','max:100','min:8'],
            'cod_colaborador' => [$this->requiredIfMethod('POST'), 'min:1','max:3','string'],
            'cargo' => [$this->requiredIfMethod('POST'), 'string','min:4','max:100'],
            'titulo' => [$this->requiredIfMethod('POST'), 'string','min:2','max:50'],
            'id_distrito' => [$this->requiredIfMethod('POST'), 'integer','exists:ctl_distrito,id'],
            'roles' => [$this->requiredIfMethod('POST'), 'array','min:1'],
            'roles.*' => [$this->requiredIfMethod('POST'), 'integer','exists:ctl_roles,id'],
            'firmador' => [$this->requiredIfMethod('POST'), 'boolean']
        ];
    }
}
