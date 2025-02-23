//GO BACKN-SERVRER
#include <stdio.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <string.h>
#include <time.h>
#include <stdlib.h>
#include <ctype.h>
#include <arpa/inet.h>

#define W 5    // Window size
#define P1 150  // Probability threshold for sending acknowledgment
#define P2 210  // Probability threshold for sending timeout signal

char a[10]; // Buffer for receiving data
char b[10]; // Buffer for timeout signal

void alpha9(int); // Function declaration for converting integer to string

int main() {
    struct sockaddr_in ser, cli;
    int s, n, sock, i, j, c = 1, f;
    unsigned int s1;

    // Creating socket
    s = socket(AF_INET, SOCK_STREAM, 0);

    // Initializing server address structure
    ser.sin_family = AF_INET;
    ser.sin_port = 6500;
    ser.sin_addr.s_addr = inet_addr("127.0.0.1");

    // Binding socket
    bind(s, (struct sockaddr*)&ser, sizeof(ser));

    // Listening for connections
    listen(s, 1);

    n = sizeof(cli);
    // Accepting connection
    sock = accept(s, (struct sockaddr*)&cli, &n);
    printf("\nTCP Connection Established.\n");

    // Generating random seed for timeout calculations
    s1 = (unsigned int)time(NULL);
    srand(s1);

    // Copying "TimeOut" to buffer b
    strcpy(b, "TimeOut");

    // Receiving timeout value from client
    recv(sock, a, sizeof(a), 0);
    f = atoi(a); // Converting received timeout value to integer

    while (1) {
        // Receiving data frames
        for (i = 0; i < W; i++) {
            recv(sock, a, sizeof(a), 0);
            if (strcmp(a, b) == 0) {
                break;
            }
        }
        i = 0;
        while (i < W) {
            j = rand() % P1;
            if (j < P2) {
                // Sending timeout signal
                send(sock, b, sizeof(b), 0);
                break;
            } else {
                alpha9(c);
                if (c <= (f + 1)) {
                    printf("\nFrame %s Received", a);
                    send(sock, a, sizeof(a), 0); // Sending acknowledgment
                } else {
                    break;
                }
                c++;
            }
            if (c > f) {
                break;
            }
            i++;
        }
    }

    // Closing sockets
    close(sock);
    close(s);
    return 0;
}

// Function to convert integer to string
void alpha9(int z) {
    int k, i, g;
    char a[10]; // Temporary buffer for string conversion

    i = 0, j, g;
    k = z;
    while (k > 0) {
        i++;
        k = k / 10;
    }
    g = i;
    i--;
    while (z > 0) {
        k = z % 10;
        a[i] = k + 48; // Converting integer to ASCII
        i--;
        z = z / 10;
    }
    a[g] = '\0'; // Null-terminating the string
}
