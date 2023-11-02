@extends('layouts.root.main')

@section('main')
    <div class="row" style="margin-top: -30px">
        <div class="card bg-light-success shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">DCAA07</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    Status
                                </li>
                                <li class="breadcrumb-item">
                                    <span class="badge bg-success px-4">RUNNING</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <img src="{{ asset('assets/images/mapping-per-line.png') }}" alt="" class="mw-100" usemap="#roomMap"
                width="980vh">

            <div style="position: absolute; top: 60vh; left: 28vh;">
                <img src="../../dist/images/profile/tri.png" alt="Employee 1" style="width: 80px; height: 80px;"
                    class="rounded-1" />
            </div>

            <div style="position: absolute; top: 71vh; left: 44vh;">
                <img src="../../dist/images/profile/syarief.png" alt="Employee 2" style="width: 80px; height: 80px;"
                    class="rounded-1" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row text-center">
                <div class="col-lg-12">
                    <div class="card overflow-hidden card-hover">
                        <div class="d-flex flex-row">
                            <div class="p-3">
                                <h3 class="text-success mb-0 fs-6 fw-bolder pb-2">METHOD</h3>
                                <span class="text-muted">No Henkaten</span>
                            </div>
                            <div class="align-self-center me-3 ms-auto">
                                <h2 class="fs-7 text-success mb-0"></h2>
                            </div>
                            <div class="p-4 bg-success">
                                <h3 class="text-white box mb-0">
                                    <i class="ti ti-circle"></i>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card overflow-hidden card-hover">
                        <div class="d-flex flex-row">
                            <div class="p-3">
                                <h3 class="text-success mb-0 fs-6 fw-bolder pb-2">MAN</h3>
                                <span class="text-muted">No Henkaten</span>
                            </div>
                            <div class="align-self-center me-3 ms-auto">
                                <h2 class="fs-7 text-success mb-0"></h2>
                            </div>
                            <div class="p-4 bg-success">
                                <h3 class="text-white box mb-0">
                                    <i class="ti ti-circle"></i>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card overflow-hidden card-hover">
                        <div class="d-flex flex-row">
                            <div class="p-3">
                                <h3 class="text-success mb-0 fs-6 fw-bolder pb-2">MACHINE</h3>
                                <span class="text-muted">No Henkaten</span>
                            </div>
                            <div class="align-self-center me-3 ms-auto">
                                <h2 class="fs-7 text-danger mb-0"></h2>
                            </div>
                            <div class="p-4 bg-success">
                                <h3 class="text-white box mb-0">
                                    <i class="ti ti-circle"></i>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card overflow-hidden card-hover">
                        <div class="d-flex flex-row">
                            <div class="p-3">
                                <h3 class="text-success mb-0 fs-6 fw-bolder pb-2">MATERIAL</h3>
                                <span class="text-muted">No Henkaten</span>
                            </div>
                            <div class="align-self-center me-3 ms-auto">
                                <h2 class="fs-7 text-danger mb-0"></h2>
                            </div>
                            <div class="p-4 bg-success">
                                <h3 class="text-white box mb-0">
                                    <i class="ti ti-circle"></i>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="text-muted mb-2 fw-bolder">Man Power</h5>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="../../dist/images/profile/tri.png" class="rounded-1 img-fluid" width="100">
                            <div class="mt-n2">
                                <span class="badge bg-warning">OPERATOR</span>
                                <h3 class="card-title mt-3">Ahmad Tri</h3>
                                <h6 class="card-subtitle">003921</h6>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button class="btn btn-warning" style="width: 100% !important">POS 1</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="../../dist/images/profile/syarief.png" class="rounded-1 img-fluid" width="100">
                            <div class="mt-n2">
                                <span class="badge bg-danger">JP</span>
                                <h3 class="card-title mt-3">Syarief</h3>
                                <h6 class="card-subtitle">002899</h6>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button class="btn btn-danger" style="width: 100% !important">POS 2</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="../../dist/images/profile/saiful.png" class="rounded-1 img-fluid" width="100">
                            <div class="mt-n2">
                                <span class="badge bg-dark">LEADER</span>
                                <h3 class="card-title mt-3">Saiful</h3>
                                <h6 class="card-subtitle">002899</h6>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button class="btn btn-dark" style="width: 100% !important">PIC</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="product-list">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-9">
                        <form class="position-relative">
                            <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                placeholder="Search Product">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                        <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Filter list"><i class="ti ti-filter"></i></a>
                    </div>
                    <div class="table-responsive border rounded">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </th>
                                    <th scope="col">Henkaten</th>
                                    <th scope="col">Problem</th>
                                    <th scope="col">status</th>
                                    <th scope="col">Penanganan</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../../dist/images/products/s1.jpg" class="rounded-circle"
                                                alt="..." width="56" height="56">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-0 fs-4">Machine</h6>
                                                <p class="mb-0">DCAA01</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Mesin bagian A problem</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-success p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Uncritical</p>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fs-4">Diganti</h6>
                                    </td>
                                    <td><a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit"><i
                                                class="ti ti-dots-vertical"></i></a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../../dist/images/products/s2.jpg" class="rounded-circle"
                                                alt="..." width="56" height="56">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-0 fs-4">Machine</h6>
                                                <p class="mb-0">DCAA01</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Mesin bagian B problem</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-danger p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Critical</p>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fs-4">Beli baru</h6>
                                    </td>
                                    <td><a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit"><i
                                                class="ti ti-dots-vertical"></i></a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../../dist/images/products/s3.jpg" class="rounded-circle"
                                                alt="..." width="56" height="56">
                                            <div class="ms-3">
                                                <h6 class="fw-semibold mb-0 fs-4">Machine</h6>
                                                <p class="mb-0">DCAA01</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Mesin bagian C problem</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-success p-1 rounded-circle"></span>
                                            <p class="mb-0 ms-2">Critical</p>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fs-4">Ganti</h6>
                                    </td>
                                    <td><a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Edit"><i
                                                class="ti ti-dots-vertical"></i></a></td>
                            </tbody>
                        </table>
                        <div class="d-flex align-items-center justify-content-end py-1">
                            <p class="mb-0 fs-2">Rows per page:</p>
                            <select class="form-select w-auto ms-0 ms-sm-2 me-8 me-sm-4 py-1 pe-7 ps-2 border-0"
                                aria-label="Default select example">
                                <option selected="">5</option>
                                <option value="1">10</option>
                                <option value="2">25</option>
                            </select>
                            <p class="mb-0 fs-2">1–5 of 12</p>
                            <nav aria-label="...">
                                <ul class="pagination justify-content-center mb-0 ms-8 ms-sm-9">
                                    <li class="page-item p-1">
                                        <a class="page-link border-0 rounded-circle text-dark fs-6 round-32 d-flex align-items-center justify-content-center"
                                            href="#"><i class="ti ti-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item p-1">
                                        <a class="page-link border-0 rounded-circle text-dark fs-6 round-32 d-flex align-items-center justify-content-center"
                                            href="#"><i class="ti ti-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
