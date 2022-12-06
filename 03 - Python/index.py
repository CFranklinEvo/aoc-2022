lines = open('input.txt', 'r').read().splitlines()

letterLookup = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']

p1Total = 0
p2Total = 0

for index, line in enumerate(lines, start=1):
    compartmentSize = (len(line) // 2)
    left, right = line[:compartmentSize], line[compartmentSize:]

    for char in left:
        if char not in right:
            continue

        foundChar = char
        break

    p1Total += letterLookup.index(foundChar) + 1

    if (index % 3 == 0):
        for char in line:
            # Accounting for index start=1
            if char in lines[index -2] and char in lines[index -3]:
                foundBadge = char
                break

        p2Total += letterLookup.index(foundBadge) + 1


print(f'Part 1: {p1Total}')
print(f'Part 2: {p2Total}')
