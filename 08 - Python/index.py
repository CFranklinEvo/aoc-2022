tree_arr = open('input.txt', 'r').read().splitlines()
last_col = len(tree_arr) - 1
last_row = len(tree_arr[0]) - 1

p1_total = 0 # Visible Trees
p2_answer = 0

def is_edge_tree(x, y):
    return ((x == 0) or (y == 0) or (x == last_row) or (y == last_col))


# Part 1
def check_direction(is_x, tree_range, x, y):
    tree_val = tree_arr[y][x]

    for num in tree_range:
        next_tree = tree_arr[y][num] if is_x else tree_arr[num][x]
        if (next_tree >= tree_val): return False

    return True


def is_tree_visible(x, y):
    if (is_edge_tree(x, y)):
        return True

    if (check_direction(False, range((y - 1), -1, -1), x, y)): return True # Top
    if (check_direction(True, range((x + 1), last_col + 1), x, y)): return True # Right
    if (check_direction(False, range((y + 1), last_row + 1), x, y)): return True # Bottom
    if (check_direction(True, range((x - 1), -1, -1), x, y)): return True # Left

    return False


# Part 2
def trees_visible_in_direction(is_x, tree_range, x, y):
    tree_val = tree_arr[y][x]
    count = 1

    for num in tree_range:
        current_x = num if is_x else x
        current_y = y if is_x else num

        next_tree = tree_arr[current_y][current_x]

        if (is_edge_tree(current_x, current_y) or next_tree >= tree_val):
            break
        else:
            count += 1

    return count


def get_scenic_score(x, y):
    if (is_edge_tree(x, y)):
        return 0

    top_score = trees_visible_in_direction(False, range((y - 1), -1, -1), x, y)
    right_score = trees_visible_in_direction(True, range((x + 1), last_col + 1), x, y)
    bottom_score = trees_visible_in_direction(False, range((y + 1), last_row + 1), x, y)
    left_score = trees_visible_in_direction(True, range((x - 1), -1, -1), x, y)

    return top_score * right_score * bottom_score * left_score


# Tree Loop
for y, row in enumerate(tree_arr):
    for x, tree in enumerate(row):
        if (is_tree_visible(x, y)):
            p1_total += 1

        p2_value = get_scenic_score(x, y)
        p2_answer = p2_value if p2_value > p2_answer else p2_answer

print(f'Part 1: {p1_total}')
print(f'Part 2: {p2_answer}')
