#include<stdio.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<netinet/in.h>
#include<string.h>
#include<time.h>
#include<stdlib.h>
#include<ctype.h>

#define W 5  // Window size
char a[10]; // Buffer for sending data
char b[10]; // Buffer for timeout signal

void alpha9(int); // Function declaration for converting integer to string

int main() {
    int s, f, wl, c = 1, x, i = 0, j, n, p = 0, e = 0;
    struct sockaddr_in ser;

    // Creating a socket
    s = socket(AF_INET, SOCK_STREAM, 0);

    // Initializing server address structure
    ser.sin_family = AF_INET;
    ser.sin_port = 6500;
    ser.sin_addr.s_addr = inet_addr("127.0.0.1");

    // Establishing connection with the server
    connect(s, (struct sockaddr*)&ser, sizeof(ser));
    printf("\nTCP Connection Established.\n");

    // Getting the number of frames from the user
    printf("\nEnter the number of Frames:");
    scanf("%d", &f);

    // Converting the number of frames to string and sending it to the server
    alpha9(f);
    send(s, a, sizeof(a), 0);

    // Initializing the timeout signal
    strcpy(b, "TimeOut");

    // Main loop for sending and receiving frames
    while (1) {
        // Sending frames in batches of size W
        for (i = 0; i < W; i++) {
            alpha9(c);
            send(s, a, sizeof(a), 0);
            if (c <= f) {
                printf("\nFrame %d Sent", c);
                c++;
            }
        }
        i = 0;
        wl = W;

        // Receiving acknowledgments and handling timeouts
        while (i < W) {
            // Receiving acknowledgment or timeout signal
            recv(s, a, sizeof(a), 0);
            p = atoi(a);

            // Checking for timeout signal
            if (strcmp(a, b) == 0) {
                // Handling timeout by resending frames
                e = c - wl;
                if (e <= f) {
                    printf("\nTimeOut, Resent Frame %d onwards", e);
                }
                break;
            } else {
                // Handling acknowledgment
                if (p <= f) {
                    printf("\nFrame %s Acknowledged", a);
                    wl--;
                } else {
                    break;
                }
            }
            if (p > f) {
                break;
            }
            i++;
        }

        // Checking if all frames have been acknowledged and all frames have been sent
        if (wl == 0 && c > f) {
            // Sending the timeout signal to terminate communication
            send(s, b, sizeof(b), 0);
            break;
        } else {
            // Updating the sequence number for next batch of frames
            c = c - wl;
            wl = W;
        }
    }

    // Closing the socket
    close(s);
    return 0;
}

// Function to convert integer to string
void alpha9(int z) {
    int k, i = 0, j, g;
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
