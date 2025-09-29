<?php

namespace App\Livewire;

use App\Models\Inventarios\Equipo;
use Livewire\Component;

class SelectEquipo extends Component
{
    public $search = '';
    public $equipos = [];
    public $selectedEquipoId = null; // Este es el valor que se enviará con el formulario
    public $selectedEquipoText = ''; // Este es el texto que se muestra en el input

    public $name;
    public $label;
    public $placeholder;
    public $required = false;
    public $initialEquipoId = null;

    public function mount()
    {
        // Si hay un valor inicial (ej. en el formulario de edición), cargar el equipo
        if ($this->initialEquipoId) {
            $equipo = Equipo::with('tipo')->find($this->initialEquipoId);
            if ($equipo) {
                $this->selectedEquipoId = $equipo->id;
                $this->selectedEquipoText = $equipo->tipo?->nombre . ' — ' . $equipo->numero_serie;
                $this->search = $this->selectedEquipoText; // Rellenar la búsqueda con el texto del equipo inicial
            }
        }
    }

    public function updatedSearch()
    {
        $this->selectedEquipoId = null; // Limpiar el ID seleccionado si el usuario empieza a escribir de nuevo
        $this->selectedEquipoText = ''; // Limpiar el texto seleccionado
        
        if (strlen($this->search) < 2) {
            $this->equipos = [];
            return;
        }

        $this->equipos = Equipo::query()
            ->with('tipo')
            ->where(function($query) {
                $query->where('numero_serie', 'like', '%' . $this->search . '%')
                      ->orWhere('id_activo_fijo', 'like', '%' . $this->search . '%')
                      ->orWhere('marca', 'like', '%' . $this->search . '%')
                      ->orWhere('modelo', 'like', '%' . $this->search . '%');
            })
            ->limit(10)
            ->get();
    }

    public function selectEquipo($equipoId)
    {
        $equipo = Equipo::with('tipo')->find($equipoId);
        if ($equipo) {
            $this->selectedEquipoId = $equipo->id; // Guarda el ID real
            $this->selectedEquipoText = $equipo->tipo?->nombre . ' — ' . $equipo->numero_serie; // Guarda el texto para mostrar
            $this->search = $this->selectedEquipoText; // Rellenar el input de búsqueda con el texto del seleccionado
            $this->equipos = []; // Ocultar resultados
        }
    }

    public function render()
    {
        return view('livewire.select-equipo');
    }
}