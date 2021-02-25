<template>
    <div >
		<!-- Content Header (Page header) -->	  
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Companies</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Companies</li>
					</ol>
				</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>


		<div class="content">
			<div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Companies</h3>
                                <div class="card-tools ">
                                    <button class="push-right btn btn-sm btn-primary"  @click='NewCompany()'>New Company</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                
                                <table class="table table-bordered table-responsive1 table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Admin Name</th>
                                        <th>Email</th>
                                        <th>URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(company, index) in companies" :key="index">
                                        <td>{{ index+1 }}</td>
                                        <td>logo here</td>
                                        <td>{{ company.name }}</td>
                                        <td>{{ company.admin.name }}</td>
                                        <td>{{ company.admin.email }}</td>
                                        <td>{{ company.url }}</td>
                                        <td>    
                                            <div class="btn-group">
                                                <button type="button" @click.prevent="editCompany(company)" title='Edit' class="btn btn-sm btn-primary"><i class="fa fa-edit white"></i></button>
                                                <button type="button" @click.prevent="deleteCompany(company.id)" title='Delete' class="btn btn-sm btn-danger"><i class="fa fa-trash white"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                                    <div v-if="loading">
                                        <div class="d-flex justify-content-center">
                                            <div class="spinner-border text-primary" style="margin:30px; width: 4rem; height: 4rem;" role="status">
                                                <center><span class="sr-only">Loading...</span></center>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- /.card-body -->
                        
                        </div>
                        <!-- /.card -->
                    </div>
                    
                </div>
			</div><!-- /.container-fluid -->
		</div>
		<!-- Main content -->

        <div class="modal fade" id="companyModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AddNewLabel">{{editingCompany ? 'Update' : 'New'}} Company</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name" required
                                    class="form-control" :class="{ 'is-invalid': companyForm.errors.has('name') }">
                                    <small v-if="companyForm.errors.has('name')" class="text-danger"></small>
                        </div> 

                        

					</div>
					<div class="modal-footer ">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editingCompany" @click="updateCompany"  type="submit" class="btn btn-success pull-right">Update</button>
                            <button v-show="!editingCompany" @click="createCompany" type="submit" class="btn btn-primary pull-right">Create</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		
	</div>
</template>


<script>
    import Form from "vform/src/Form";

    export default {
        data(){
            return {
                companies : {},
                departments : {},
                loading: false,
                fetching: false,

                editingCompany: false,

                companyForm:new Form({
                    id:'',
                    company_name:'',
                    name:'',
                    email:'',
                    password:'',
                    logo: '', 
                    url: ''
                }),
            }
        },
        methods:{

            loadCompanies(){
                this.loading = !this.loading
                axios.get("api/company").then(({data})=>{ this.companys = data.courses } );

                axios.get("api/department").then(({data})=>{ 
                    this.departments = data.departments
                    this.loading = !this.loading
                } );
            },

            NewCompany(){
                this.editingCompany= false;
                this.companyForm.reset();
                $('#companyModal').modal('show');
            },
            createCompany(){
                this.companyForm.post('api/company')
                    .then(() =>{
                        Toast.fire({ icon: 'success', title: 'New Company Added Successfully' })
                        this.loadCompanies();
                         $('#companyModal').modal('hide');
                    });
            },
            editCompany(department){
                this.companyForm.reset();
                this.editingCompany=true;
                this.companyForm.fill(department);
                $('#companyModal').modal('show');
            },
            updateCompany(){
                this.companyForm.put('api/company/' + this.companyForm.id)
                    .then(()=>{
                        Toast.fire({ icon: 'success', title: 'Company Updated Successfully' })

                        this.loadCompanies();
                         $('#companyModal').modal('hide');
                    });
            },
            deleteCompany(id){
                axios.delete("api/company/"+ id).then(()=>{ 
                    Toast.fire({ icon: 'success', title: 'Company Deleted Successfully' })

                    this.loadCompanies();
                });
            },
       
        },

        mounted() {

            this.loadCompanies();

        }
    }
</script>