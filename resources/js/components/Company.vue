<template>
    <div >
		<!-- Content Header (Page header) -->	  
		<section class="content-header">
			<div class="container">
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
			<div class="container">
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
                                            <td><img v-bind:src="'/companies/logo/'+company.logo" height="65" width="65" /></td>
                                            <td>{{ company.name }}</td>
                                            <td>{{ company.admin.fullname }}</td>
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
                            <div class="card-footer clearfix">
								<pagination class="float-right" :data="companies" @pagination-change-page="loadCompanies">
									<span slot="prev-nav">&lt; Previous</span>
									<span slot="next-nav">Next &gt;</span>
								</pagination>
							</div>
                        
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
                            <input type="text" name="fullname" id="fullname" required v-model="companyForm.fullname"
                                    class="form-control" :class="{ 'is-invalid': errorMsg.fullname }">
                                    <small v-if="errorMsg.fullname" class="text-danger">{{errorMsg.fullname}}</small>
                        </div> 
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="name" id="name" required v-model="companyForm.name"
                                    class="form-control" :class="{ 'is-invalid': errorMsg.name }">
                                    <small v-if="errorMsg.name" class="text-danger">{{errorMsg.name}}</small>
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" ref="fileupload" @change="onFileChange" class="form-control-file" >
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="name" id="url" required v-model="companyForm.url"
                                    class="form-control" :class="{ 'is-invalid': errorMsg.url }">
                                    <small v-if="errorMsg.url" class="text-danger">{{errorMsg.url}}</small>
                        </div> 
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="companyForm.email" type="text" name="email" id="email" required 
                                    class="form-control" :class="{ 'is-invalid': errorMsg.email }">
                                    <small class="text-danger"><span>{{ errorMsg.email }}</span></small>
                        </div>

                        <div v-if="!editingCompany" class="form-group">
                            <label>New Password</label>
                            <input v-model="companyForm.password" type="password" name="password" :class="{ 'is-invalid': errorMsg.password }" id="password" required class="form-control">
                        </div> 

                        <div v-if="!editingCompany" class="form-group">
                            <label>Confirm Password</label>
                            <input v-model="companyForm.password_confirmation" type="password" name="password_confirmation" id="password_confirmation" required class="form-control"
                            :class="{ 'is-invalid': errorMsg.password }">
                            <small v-if="errorMsg.password" class="text-danger">{{errorMsg.password}}</small>
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
                    fullname:'',
                    name:'',
                    email:'',
                    password:'',
                    logo: '', 
                    url: ''
                }),
                errorMsg: {
                    fullname:'',
                    name:'',
                    email:'',
                    password:'',
                    logo: '', 
                    url: ''
                }
            }
        },
        methods:{

            loadCompanies(){
                this.loading = !this.loading
                axios.get("api/company").then(({data})=>{ 
                    this.companies = data.data.data
                    this.loading = !this.loading
                });
            },

            onFileChange(e) {
                let file = e.target.files[0];
                this.companyForm.logo = e.target.files[0];

                var reader = new FileReader();
                if (file["size"] > 1000000) {
                    Toast.fire({ icon: "error", title: "File size exceeds 1Mb" });
                }
                if (!file["name"].match(/.(jpg|jpeg|png|gif)$/i)) {
                    Toast.fire({
                        icon: "error",
                        title: "Unsupported File Format, Only Image Files Allowed"
                    });

                    this.$refs.fileupload.value = null;
                }

            },


            NewCompany(){
                this.editingCompany= false;
                this.companyForm.reset();
                $('#companyModal').modal('show');
            },
            createCompany1(){
                this.companyForm.post('api/company')
                    .then(() =>{
                        Toast.fire({ icon: 'success', title: 'New Company Added Successfully' })
                        this.loadCompanies();
                         $('#companyModal').modal('hide');
                    });
            },
            createCompany(){

                let formData = new FormData();
				formData.append('fullname', this.companyForm.fullname);
				formData.append('password', this.companyForm.password);
				formData.append('password_confirmation', this.companyForm.password_confirmation);
				formData.append('url', this.companyForm.url);
				formData.append('email', this.companyForm.email);
				formData.append('name', this.companyForm.name);
				formData.append('logo', this.companyForm.logo);

				let config = {
					headers: { 'content-type': 'multipart/form-data' }
				}

				axios.post('api/company', formData, config)
					.then(({ data }) => {
                        Toast.fire({ icon: 'success', title: 'New Company Added Successfully' })
                        this.loadCompanies();
                         $('#companyModal').modal('hide');
                    }).catch((error) => {
                        
                        this.processErros(error.response.data.errors)
                    });


            },
            processErros(error){
                this.errorMsg.email =  error.email ? error.email[0] : ''
                this.errorMsg.fullname =  error.fullname ? error.fullname[0] : ''
                this.errorMsg.name =  error.name ? error.name[0] : ''
                this.errorMsg.url =  error.url ? error.url[0] : ''
                this.errorMsg.password =  error.password ? error.password[0] : ''
                this.errorMsg.password_confirmation =  error.password_confirmation ? error.password_confirmation[0] : ''

            },
            editCompany(company){
                this.companyForm.reset();
                this.editingCompany=true;
                this.companyForm.fill(company);
                this.companyForm.email = company.admin.email;
                this.companyForm.fullname =company.admin.fullname;
                $('#companyModal').modal('show');
            },
            updateCompany(){
                
                 let dataUpdateForm = new FormData();
				dataUpdateForm.append('fullname', this.companyForm.fullname);
				dataUpdateForm.append('url', this.companyForm.url);
				dataUpdateForm.append('email', this.companyForm.email);
				dataUpdateForm.append('name', this.companyForm.name);
				dataUpdateForm.append('logo', this.companyForm.logo);
				dataUpdateForm.append("_method", "PATCH");

				let config = {
					headers: { 'content-type': 'multipart/form-data' }
				}
                    console.log('<===>  ', this.companyForm)

                axios.post('api/company/' + this.companyForm.id, dataUpdateForm, config)
                .then(({ data }) => {
                    Toast.fire({ icon: 'success', title: 'Company Updated Successfully' })
                    this.loadCompanies();
                    $('#companyModal').modal('hide');
                }).catch((error) => {
                    
                    this.processErros(error.response.data.errors)
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