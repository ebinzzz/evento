# Number of rows for the pattern
rows = 11

# First half of the pattern
for i in range(rows, 1, -1):
    for j in range(1, i):
        print("*", end=' ')
    for k in range(rows*2 - 2*i):
        print(" ", end=' ')
    for j in range(1, i):
        print("*", end=' ')
    print()

# Second half of the pattern
for i in range(2, rows + 1):
    for j in range(1, i):
        print("*", end=' ')
    for k in range(rows*2 - 2*i):
        print(" ", end=' ')
    for j in range(1, i):
        print("*", end=' ')
    print()
