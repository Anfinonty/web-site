#include <stdio.h>
#include <stdbool.h>
#include <stdlib.h>
#include <string.h>

//#include <unistd.h>
//#include <conio.h>
//#include <time.h>


bool file_exists(const char *filename) { //https://www.learnc.net/c-tutorial/c-file-exists
  FILE *fp = fopen(filename,"r");
  if (fp!=NULL) {
    fclose(fp);
    return true;
  }  
  return false;
}


void SendCode() { //Sends Code
  const char *f_name="C:/Apache2.2/htdocs/global/RegistrationBox/tmp.txt";
  if (file_exists(f_name)) {
    //get email from file
    //send email with vbs script
    //delete email.txt
  }
}


void CreateToken() { //Create Token.txt - used by users to make changes to htdocs
  FILE *token_file;
  const char *f_name="C:/Apache2.2/htdocs/global/Sessions/token.txt";
  if (!file_exists(f_name)) { //if token doesnt exists
    token_file=fopen(f_name,"w");
    fclose(token_file);
    //printf("[&] Token Created.\n"); //create token
  } /*else {
    printf("[!] Token already exists.\n");
  }*/
}


void AnimateServerTask() { //server task
  FILE *a_file;
  const char *f_name_regq="C:/Apache2.2/htdocs/global/{RegQ}/registerQ.txt";
  const char *str1=""; //part1
  const char *str2=""; //part2
  const int maxtick=59999999;

  int email_txt_pos=0;
  int reg_code_txt_pos=0;
  int total_file_txt_pos=0;

  const int total_file_txt_len=512;
  const int vbs_txt_len=768;
  const int email_txt_len=256;
  const int reg_code_len=17;

  char vbs_txt[vbs_txt_len];
  char total_file_txt[total_file_txt_len];
  char email_txt[email_txt_len];
  char reg_code[reg_code_len];

  char character;
  bool writing_email=true;

  int i;
  int time=0;

  const char *rcpemail="const RCPEMAIL=\"";
  const char *body="const BODY=\"The-Code-Is-";


  while (true) {
    time++;
    if (time==maxtick) {
      //CreateToken();
      if (file_exists("C:/Apache2.2/htdocs/global/{RegQ}/in_progress.txt")) {//if RegQ/in_progress exists      
        if (file_exists(f_name_regq)) {//if registrationQ exists
	  //init the arrays and vars
	  writing_email=true;
	  email_txt_pos=0;
	  reg_code_txt_pos=0;
	  total_file_txt_pos=0;
	  for (i=0;i<email_txt_len;i++) {
	    email_txt[i]=0;
	  }
	  for (i=0;i<reg_code_len;i++) {
	    reg_code[i]=0;
	  }
	  for (i=0;i<total_file_txt_len;i++) {
	    total_file_txt[i]=0;
	  }

	  a_file=fopen(f_name_regq,"r");//open file
	  fgets(total_file_txt,total_file_txt_len,a_file);//read file
	  fclose(a_file);//close file

	  //printf("total_file_txt: %s",total_file_txt);

	  remove(f_name_regq); //delete RegQ, makes this only run once

	  while (reg_code_txt_pos<reg_code_len-1) {
            character=total_file_txt[total_file_txt_pos];
	    if (writing_email) {
	      if (character!=',' && email_txt_pos<email_txt_len) {
	        email_txt[email_txt_pos]=character;
	        email_txt_pos++;
	      } else {
	        writing_email=false;
	      }
	    } else {
	      reg_code[reg_code_txt_pos]=character;
	      reg_code_txt_pos++;
	    }
	    total_file_txt_pos++;
	    if (total_file_txt_pos>=total_file_txt_len) {
	      reg_code_txt_pos=reg_code_len;
	    }
	  } /// end while
	  //printf("email:%s\n\n",email_txt);
	  //printf("regCode:%s\n\n",reg_code);


	  //write script vbs
	  //init vbs_txt
  	  for (i=0;i<vbs_txt_len;i++) {
    	    vbs_txt[i]=0;
  	  }

  	//read file to get string for vbs script
  	  a_file=fopen("servertask_vbs.txt","r");//open file

 	  int vbs_txt_pos=0;
  	  do {
            character = fgetc(a_file);
    	    vbs_txt[vbs_txt_pos]=character;
   	    vbs_txt_pos++;
  	  } while (character != EOF); //read while not end of file

	  fclose(a_file);//close file

	  //begin writing vbs script
	  a_file=fopen("server_send_email.vbs","ab");//open file

	  //write email
	  fwrite(rcpemail,1,strlen(rcpemail),a_file);
	  fwrite(email_txt,1,strlen(email_txt),a_file);
	  fwrite("\"\r\n",1,3,a_file);

	  //write reg-code
  	  fwrite(body,1,strlen(body),a_file);
  	  fwrite(reg_code,1,16,a_file);
	  fwrite("\"\r\n",1,3,a_file);

	  //write the rest
	  fwrite(vbs_txt,1,vbs_txt_pos-1,a_file);

	  fclose(a_file);//close file
	  system("server_send_email.vbs");//system run vbs <--- vbs deletes in_progress and itself	  
        }
      } 
      //printf("tick\n");
   } else if (time>maxtick) {
      time=0;
    }
  }
}

int main() {
  AnimateServerTask();
  return 0;
}


