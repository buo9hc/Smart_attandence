#include "stdlib.h"
#include "string.h"
#include "unistd.h"
#include "MQTTClient.h"
#include <mysql.h>

#define ADDRESS     "tcp://broker.hivemq.com:1883"
#define CLIENTID    "iot_midterm_sever"       	     
#define SUB_TOPIC   "iot/test1/rfid"	// replace this

MYSQL *conn;
MYSQL_RES *res;
MYSQL_ROW row;

char *server = "localhost";
char *user = "admin";					// replace this
char *password = "123456";					// replace this
char *database = "DanhSachLop";			// replace this


int on_message(void *context, char *topicName, int topicLen, MQTTClient_message *message) {
    char* payload = message->payload;
    
    // replace this /////////////////////////////
    
    //char HO_TEN[255];
    char SID[30];
    //char Class[255];
    char Time_In[30];
    char Date[30];
    char Status[30];
    char CID[30];
    sscanf(payload, "%s %s %s %s %s", &SID, &Time_In, &Date, &Status, &CID);
    printf("==== Received message ====\n");
    //printf("Name: %s\n", HO_TEN);
    printf("Student ID: %s\n", SID);
    //printf("Class: %s\n", Class);
    printf("Time: %s\n", Time_In);
    printf("Date: %s %s\n", Date,Time_In);
    printf("Status: %s\n", Status);
    printf("Card ID: %s\n", CID);
    ////////////////////////////////////////////

    conn = mysql_init(NULL);
    if (mysql_real_connect(conn, server, user, password, database, 0, NULL, 0) == NULL) 
    {
        fprintf(stderr, "%s\n", mysql_error(conn));
        mysql_close(conn);
        exit(1);
    }  
    char sql[3000];
    
    // replace this:	insert into <table_name> SET (<col1>, <col2>, ...) values ('%s', '%s', ...);" , <var1>, <var2>, ...
    sprintf(sql, "insert into attendance_check (SID, Time_In, Date, Status, CID) values ('%s', '%s', '%s %s', '%s', '%s');",SID, Time_In, Date, Time_In, Status, CID);
    mysql_query(conn,sql);
    mysql_close(conn);
    printf("=> Saving succeed!\n\n");

    
    MQTTClient_freeMessage(&message);
    MQTTClient_free(topicName);
    return 1;
}

int main(int argc, char* argv[]) {
    MQTTClient client;
    MQTTClient_create(&client, ADDRESS, CLIENTID, MQTTCLIENT_PERSISTENCE_NONE, NULL);
    MQTTClient_connectOptions conn_opts = MQTTClient_connectOptions_initializer;
    MQTTClient_setCallbacks(client, NULL, NULL, on_message, NULL);

    int rc;
    if ((rc = MQTTClient_connect(client, &conn_opts)) != MQTTCLIENT_SUCCESS) {
        printf("Failed to connect, return code: %d\n", rc);
        exit(-1);
    }
  
    MQTTClient_subscribe(client, SUB_TOPIC, 0);

    while(1) {

    }
    MQTTClient_disconnect(client, 1000);
    MQTTClient_destroy(&client);
    return rc;
}
