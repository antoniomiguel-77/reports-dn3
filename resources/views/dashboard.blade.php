<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight d-flex col-md-12 justify-content-between">
            <span>Gerencie Suas Actividades</span>
            <div class="">
                <a href="{{route('report.task')}}" target="_blank" class="btn btn-md btn-primary">
                    <i class="fa fa-print"></i>
                    Relatório
                </a>
                <a href="fresh" class="btn btn-md btn-primary">
                    <i class="fa fa-arrows-rotate"></i>
                    Nova semana
                </a>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucesso!</strong> {{session('msg')}}.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close"></i>
                            </button>
                          </div>
                    @elseif(session('error')) 
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Erro!</strong> {{session('error')}}.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
  
</x-app-layout>
