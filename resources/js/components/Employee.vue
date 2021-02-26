<template>
    <div >
		<!-- Content Header (Page header) -->	  
		<section class="content-header">
			<div class="container">
				<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Employee</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Employee</li>
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
                                <h3 class="card-title">Employee</h3>
                                <div class="card-tools ">
                                    <button class="push-right btn btn-sm btn-primary"  @click='NewEmployee()'>New Employee</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                
                                <table class="table table-bordered table-responsive1 table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(employee, index) in employees" :key="index">
                                            <td>{{ index+1 }}</td>
                                            <td>{{ employee.profile.fullname }}</td>
                                            <td>{{ employee.profile.email }}</td>
                                            <td>{{ employee.company.name }}</td>
                                            <td>    
                                                <div class="btn-group">
                                                    <button type="button" @click.prevent="editEmployee(employee)" title='Edit' class="btn btn-sm btn-primary"><i class="fa fa-edit white"></i></button>
                                                    <button type="button" @click.prevent="deleteEmployee(employee.id)" title='Delete' class="btn btn-sm btn-danger"><i class="fa fa-trash white"></i></button>
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

        <div class="modal fade" id="employeeModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AddNewLabel">{{editingEmployee ? 'Update' : 'New'}} Employee</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="fullname" id="fullname" required v-model="employeeForm.fullname"
                                    class="form-control" :class="{ 'is-invalid': employeeForm.errors.has('fullname') }">
                                    <small v-if="employeeForm.errors.has('fullname')" class="text-danger">{{employeeForm.errors.errors.fullname[0]}}</small>
                        </div> 
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="company" id="company" required v-model="employeeForm.company"
                                    class="form-control" :class="{ 'is-invalid': employeeForm.errors.has('company') }">
                                    <small v-if="employeeForm.errors.has('company')" class="text-danger">{{employeeForm.errors.errors.company[0]}}</small>
                        </div> 
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="employeeForm.email" type="text" name="email" id="email" required 
                                    class="form-control" :class="{ 'is-invalid': employeeForm.errors.has('email') }">
                                    <small v-if="employeeForm.errors.has('email')" class="text-danger">{{employeeForm.errors.errors.email[0]}}</small>
                        </div>
                        <p>Default password is "password"</p>

                        

					</div>
					<div class="modal-footer ">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editingEmployee" @click="updateEmployee"  type="submit" class="btn btn-success pull-right">Update</button>
                            <button v-show="!editingEmployee" @click="createEmployee" type="submit" class="btn btn-primary pull-right">Create</button>
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
                employees : {},
                departments : {},
                loading: false,
                fetching: false,

                editingEmployee: false,

                employeeForm:new Form({
                    id:'',
                    company:'',
                    fullname:'',
                    email:'',
                    password:'',
                }),
            }
        },
        methods:{

            loadEmployees(){
                this.loading = !this.loading
                axios.get("api/employee").then(({data})=>{ 
                    this.employees = data.data.data
                    this.loading = !this.loading
                });

            },

            NewEmployee(){
                this.editingEmployee= false;
                this.employeeForm.reset();
                $('#employeeModal').modal('show');
            },
            createEmployee(){
                this.employeeForm.post('api/employee')
                    .then(() =>{
                        Toast.fire({ icon: 'success', title: 'New Employee Added Successfully' })
                        this.loadEmployees();
                         $('#employeeModal').modal('hide');
                    });
            },
            editEmployee(employee){
                this.employeeForm.reset();
                this.editingEmployee=true;
                this.employeeForm.fill(employee);
                this.employeeForm.email = employee.profile.email;
                this.employeeForm.fullname = employee.profile.fullname;
                this.employeeForm.company =employee.company.id;
                $('#employeeModal').modal('show');
            },
            updateEmployee(){
                this.employeeForm.put('api/employee/' + this.employeeForm.id)
                    .then(()=>{
                        Toast.fire({ icon: 'success', title: 'Employee Updated Successfully' })

                        this.loadEmployees();
                         $('#employeeModal').modal('hide');
                    });
            },
            deleteEmployee(id){
                axios.delete("api/employee/"+ id).then(()=>{ 
                    Toast.fire({ icon: 'success', title: 'Employee Deleted Successfully' })

                    this.loadEmployees();
                });
            },
       
        },

        mounted() {

            this.loadEmployees();

        }
    }
</script>