<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{{class_name}} as {{class_name}}Model;

class {{class_name}} extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public function render()
    {
        if ($this->id && !{{class_name}}Model::find($this->id)) {
            abort(404);
        }
    return view('livewire.{{class_name}}.index',
        [
            'results' => $this->id ? {{class_name}}Model::find($this->id) : {{class_name}}Model::paginate(10),
            'fillables' => (new {{class_name}}Model())->getFillable(),
        ]);
    }

    public function create()
    {
        ${{class_name}} = new {{class_name}}Model();
        foreach ($this->form as $key => $value) {
            ${{class_name}}->$key = $value;
        }
        ${{class_name}}->save();
    }

    public function update()
    {
        ${{class_name}} = {{class_name}}Model::find($this->id);
        foreach ($this->form as $key => $value) {
            ${{class_name}}->$key = $value;
        }
        ${{class_name}}->save();
    }

    public function delete($id)
    {
        ${{class_name}} = {{class_name}}Model::find($id);
        ${{class_name}}->delete();

        return redirect()->route(strtolower('{{class_name}}'));
    }
}
