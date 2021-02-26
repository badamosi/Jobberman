<template>
    <div >
		<!-- Content Header (Page header) -->	  
		<section class="content-header">
			<div class="container">
				<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Password</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Password</li>
					</ol>
				</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>


		<div class="content">
			<div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>
                                <div class="card-tools ">
                                    <button class="push-right btn btn-sm btn-primary"  @click='changePassword()'>Proceed</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input v-model="userForm.current_password" type="password" name="name" id="course" required class="form-control"
                                    :class="{ 'is-invalid': userForm.errors.has('current_password') }">
                                    <small v-if="userForm.errors.has('current_password')" class="text-danger">Current passowrd not correct!</small>
                                </div> 
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input v-model="userForm.new_password" type="password" name="name" id="course" required class="form-control"
                                    :class="{ 'is-invalid': userForm.errors.has('new_password') }">
                                </div> 
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input v-model="userForm.new_confirm_password" type="password" name="name" id="course" required class="form-control"
                                    :class="{ 'is-invalid': userForm.errors.has('new_confirm_password') }">
                                    <small v-if="userForm.errors.has('new_confirm_password')" class="text-danger">{{userForm.errors.errors.new_confirm_password[0]}}</small>
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
	</div>
</template>


<script>
    import Form from "vform/src/Form";

    export default {
        data(){
            return {
                userForm:new Form({
                    current_password:'',
                    new_password: '', 
                    new_confirm_password: '', 
                }),
            }
        },
        methods:{

            changePassword(){
                this.userForm.post('/api/profile/change_password')
                    .then(() =>{
                        Toast.fire({ icon: 'success', title: 'Password changed successfully!' })
                    });
                   
            },
       
        },
       
    }
</script>