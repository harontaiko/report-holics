<div class="content-wrapper">

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="fas fa-cash-register"></i>
            </span> Invoices
        </h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="form-group p-2">
                    <div class="input-group">
                        <input id="invoice-item" style="width: 50% !important; border: 1px solid #007bff;" type="text"
                            class="form-control p-2" placeholder="item name / sale date use dd-mm-yyy"
                            aria-label="item name / sale date e.g dd/mm/yyy" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-gradient-primary" id="search-" type="button">Search</button>
                        </div>
                    </div>
                </div>
                <div id="invoice-result" class="mt-4">
                    </tbody>
                    </table>
                </div>
            </div>
            <div id="invoice-loading"></div>
        </div>
    </div>
</div>