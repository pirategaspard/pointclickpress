<?php 
/*
	Evaluate action class for PointClickPress
	Execute arbitrary PHP code. 
 */

class action_eval extends Model_Base_PCPActionDef
{	
	protected $label = "Eval";
	protected $description = "Execute arbitrary PHP code. Use with caution." ;	
	
	public function performAction($args=array(),$hook_name='')
	{				
		if ($this->validate($args['action_value']))
		{					
			$result = eval($args['action_value']);	
			if ((isset($result))&&(is_array($result))&&($result[0] instanceof pcpresponse))
			{
				$response = $result;
			}
		}
		
		//var_dump(StoryData::getStorydata()); die();
				
		// you can return your own response above otherwise default is NOP
		if(!isset($response))
		{
			$response = new pcpresponse(NOP,array()); 
			return $response->asArray();
		}
		return $response;
	}
	
	private function validate($code_to_be_evaled)
	{
		$clean = true;
		$blacklist = 'exec,passthru,proc_open,proc_nice,proc_get_status,proc_close,proc_terminate,shell_exec,system,escapeshellcmd,escapeshellarg,expect_,expect_,event_,pcntl_,posix_,ftok,msg_,sem_,shm_,shmop_,file,basename,chgrp,chmod,chown,clearstatcache,copy,delete,dirname,disk_ free_ space,disk_ total_ space,diskfreespace,fclose,feof,fflush,fgetc,fgetcsv,fgets,fgetss,file_ exists,file_ get_ contents,file_ put_ contents,file,fileatime,filectime,filegroup,fileinode,filemtime,fileowner,fileperms,filesize,filetype,flock,fnmatch,fopen,fpassthru,fputcsv,fputs,fread,fscanf,fseek,fstat,ftell,ftruncate,fwrite,glob,is_ dir,is_ executable,is_ file,is_ link,is_ readable,is_ uploaded_ file,is_ writable,is_ writeable,lchgrp,lchown,link,linkinfo,lstat,mkdir,move_ uploaded_ file,parse_ ini_ file,parse_ ini_ string,pathinfo,pclose,popen,readfile,readlink,realpath_ cache_ get,realpath_ cache_ size,realpath,rename,rewind,rmdir,set_ file_ buffer,stat,symlink,tempnam,tmpfile,touch,umask,unlink,chdir,chroot,dir,closedir,getcwd,opendir,readdir,rewinddir,scandir,ftp_,url,fam,amqp,chdb,ftp,gupnp,hyperwave,http,java,ldap,gopher,,checkdnsrr,closelog ,define_syslog_variables,dns_check_record,dns_get_mx,dns_get_record,fsockopen,gethostbyaddr,gethostbyname,gethostbynamel,gethostname,getmxrr,getprotobyname,getprotobynumber,getservbyname — Get port number associated with an Internet service and protocol,getservbyport,header_remove,header,headers_list,headers_sent,inet_ntop,inet_pton,ip2long,long2ip,openlog,pfsockopen,setcookie,setrawcookie,socket_get_status,socket_set_blocking,socket_set_timeout,syslog,rrd_,socket_,sam,ssh,stomp,svm,svn,tcp,yaz_,yp,notes_,sql';
		$ablacklist = explode(',',$blacklist);
		foreach($ablacklist as $needle)
		{
			if (stripos($code_to_be_evaled,$needle))
			{
				$clean = false;
				break;
			}
		}		
		return $clean;
	}
}
?>
