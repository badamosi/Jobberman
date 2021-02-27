<template>
    <div >
		<!-- Content Header (Page header) -->	  
		<section class="content-header">
			<div class="container">
				<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Profile</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Profile</li>
					</ol>
				</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>


		<div class="content">
			<div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tools ">
                                    
                                    <button class="push-right btn btn-sm btn-primary"  @click='editProfile()'>Update Profile</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <h2>{{ currentUser.company ? currentUser.company.name : 'Admin' }}</h2>
                                <h3>Welcome! {{ currentUser.fullname }},</h3>
                                <h4>You're logged in as {{ currentUser.role | capitalize }} {{ currentUser.role == 'company'? 'Administrator' : '' }}</h4>
                            </div>

                            <!-- /.card-body -->
                        
                        </div>
                        <!-- /.card -->
                    </div>
                    
                </div>
			</div><!-- /.container-fluid -->
		</div>
		<!-- Main content -->

        <div class="modal fade" id="profileModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AddNewLabel">Update Profile</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="fullname" id="fullname" required v-model="userForm.fullname"
                                    class="form-control" :class="{ 'is-invalid': userForm.errors.has('fullname') }">
                                    <small v-if="userForm.errors.has('fullname')" class="text-danger">{{userForm.errors.errors.fullname[0]}}</small>
                        </div> 
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="userForm.email" type="text" name="email" id="email" required 
                                    class="form-control" :class="{ 'is-invalid': userForm.errors.has('email') }">
                                    <small v-if="userForm.errors.has('email')" class="text-danger">{{userForm.errors.errors.email[0]}}</small>
                        </div>

					</div>
					<div class="modal-footer ">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button @click="updateProfile"  type="submit" class="btn btn-success pull-right">Update</button>
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
                currentUser: '',
                userForm:new Form({
                    id: '',
                    fullname: '',
                    email: '', 
                }),
            }
        },
        methods:{

            editProfile(){
                this.userForm.reset();
                this.userForm.fill(this.currentUser);
                // this.userForm.email = employee.profile.email;
                // this.userForm.fullname = employee.profile.fullname;
                $('#profileModal').modal('show');
            },

            updateProfile(){
                this.userForm.put('api/profile/update/' + this.userForm.id)
                    .then(()=>{
                        Toast.fire({ icon: 'success', title: 'Profile Updated Successfully' })

                        this.getCurrentUser();
                         $('#profileModal').modal('hide');
                    });
            },

            getCurrentUser(){
                axios.get('/api/user')
                    .then(({data}) =>{
                        this.currentUser = data
                    });
            }
       
        },
        mounted(){
            this.getCurrentUser()
        }
       
    }
</script>