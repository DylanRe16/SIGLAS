<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Siglas extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'bd4'; // Conexión a la base de datos

    protected $table = 'personales'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    public $timestamps = false; // Desactivar los timestamps automáticos

    protected $fillable = [
        'cedula',
        'primer_apellido',
        'segundo_apellido',
        'primer_nombre',
        'segundo_nombre',
        'fecha_ingreso',
        'fecha_nacimiento',
        'nacionalidad',
        'sexo',
        'fecha_solicitud_const',
        'fecha_caducidad_const',
        'fecha_egreso',
        'id',
        'nenabled',
        'dfecha_creacion',
        'usuario_idcreacion',
        'dfecha_actualizacion',
        'usuario_idactualizacion',
        'fecha_jubilacion',
        'semail',
        'ntelefono_personal',
        'ntelefono_hab',
        'nentidad_entidad',
        'nmunicipio_municipio',
        'nparroquia_parroquia',
        'ndireccion1',
        'sdireccion1_2',
        'ndireccion2',
        'sdireccion2_2',
        'ndireccion3',
        'sdireccion3_2',
        'ndireccion4',
        'sdireccion4_2',
        'spunto_referencia',
        'slateralidad',
        'sdiscapacidad',
        'sinscripcion_militar',
        'nciudad',
        'ntelefono_ext',
        'scodigo_constancia',
        'nmonto_constancia',
        'dfecha_caduc_const_ant',
        'scodigo_const_venc',
        'subicacion_fisica',
        'ntelefono_oficina',
        'ncontador',
        'fecha_solicitud_const2',
        'fecha_solicitud_const3',
        'alergia',
        'tipo_alergia',
        'conyuge',
        'hijos',
        'srif',
        'nhijos',
        'snombre_emerg_familiar',
        'sapellido_emerg_familiar',
        'ntelefono_emerg_familiar',
        'sparentesco_emerg_familiar',
        'snombre_emerg_contacto',
        'sapellido_emerg_contacto',
        'ntelefono_emerg_contacto',
        'sparentesco_emerg_contacto',
        'scodigo_conapdis',
        'id_grado_discapacidad',
        'estado_civil',
        'id_grupo_sanguineo',
        'ncodigo_inscripcion_militar',
        'id_tipo_discapacidad',
        'ncant_hijos',
        'sconyuge_trabajo',
        'stalla_camisa',
        'stalla_pantalon',
        'ntalla_zapato',
        'stalla_chaqueta',
        'scargo_actual_ejerce',
        'fecha_ingreso_adm',
        'sobservacion',
        'ncont_estudios',
        'nparticipar_facilitador',
        'id_misiones',
        'id_opc_educativas',
        'nentidad_trab',
        'id_ciudad',
        'srif2',
        'sclave',
    ];
}
