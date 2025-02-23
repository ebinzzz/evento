
rows = 7

for i in range(rows, 0, -1):
    for j in range(0, i):
        print("*", end=' ')
    print()

# Second half of the pattern
for i in range(2, rows + 1):
    for j in range(0, i):
        print("*", end=' ')
    print()
