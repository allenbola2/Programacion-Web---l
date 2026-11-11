<?php
namespace App\Controllers;
use App\Models\ProductoModel;

class Productos extends BaseController
{
    public function index()
    {
        return view('productos/index', ['productos' => (new ProductoModel())->orderBy('id','DESC')->findAll()]);
    }
    public function nuevo()
    {
        return view('productos/form', ['producto' => null, 'errores' => []]);
    }
    public function guardar()
    {
        $reglas = ['nombre'=>'required|max_length[120]', 'precio'=>'required|decimal|greater_than_equal_to[0]', 'cantidad'=>'required|integer|greater_than_equal_to[0]'];
        if (!$this->validate($reglas)) return view('productos/form', ['producto'=>null, 'errores'=>$this->validator->getErrors()]);
        (new ProductoModel())->insert($this->datos());
        return redirect()->to('/productos')->with('mensaje','Producto creado');
    }
    public function editar($id)
    {
        $producto=(new ProductoModel())->find($id);
        if (!$producto) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('productos/form', ['producto'=>$producto, 'errores'=>[]]);
    }
    public function actualizar($id)
    {
        $modelo=new ProductoModel();
        $producto=$modelo->find($id);
        if (!$producto) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $reglas=['nombre'=>'required|max_length[120]', 'precio'=>'required|decimal|greater_than_equal_to[0]', 'cantidad'=>'required|integer|greater_than_equal_to[0]'];
        if (!$this->validate($reglas)) return view('productos/form', ['producto'=>$producto, 'errores'=>$this->validator->getErrors()]);
        $modelo->update($id,$this->datos());
        return redirect()->to('/productos')->with('mensaje','Producto actualizado');
    }
    public function eliminar($id)
    {
        (new ProductoModel())->delete($id);
        return redirect()->to('/productos')->with('mensaje','Producto eliminado');
    }
    private function datos(): array
    {
        return ['nombre'=>trim((string)$this->request->getPost('nombre')),
                'descripcion'=>trim((string)$this->request->getPost('descripcion')),
                'precio'=>$this->request->getPost('precio'),
                'cantidad'=>$this->request->getPost('cantidad')];
    }
}
