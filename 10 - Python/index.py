import math

instructions = open('input.txt', 'r').read().splitlines()

current_instruction = 0
total_cycles = len(instructions)
cycle = 1
x = 1

first_signal = 20
other_signals = 40

execute_in_one = ''
execute_in_two = ''

signal_strength_sum = 0
crt_rows = []

def shift_executions():
    global execute_in_one
    global execute_in_two

    execute_in_one = execute_in_two
    execute_in_two = ''

def run_executions():
    global x

    if len(execute_in_one) > 0:
        command = execute_in_one.split()

        if (command[0] != 'noop'):
            x += int(command[1])

    shift_executions()



while cycle <= total_cycles:
    # print(f'start cycle {cycle}')

    if len(instructions) > current_instruction:
        instruction = instructions[current_instruction]
        command = instruction.split()[0]

        if len(execute_in_one) == 0 and len(execute_in_two) == 0:
            if command == 'noop':
                execute_in_one = instruction
                #total_cycles += 1

            if command == 'addx':
                execute_in_two = instruction
                total_cycles += 1

            current_instruction += 1

    if (cycle == 20 or (cycle - first_signal) % other_signals == 0):
        signal_strength_sum += (x * cycle)


    crt_row = math.floor((cycle - 1) / 40)
    cell_diff = x - crt_cell

    if ((len(crt_rows) - 1) < crt_row):
        crt_rows.append([])

    crt_rows[crt_row].append('#' if (abs(cell_diff) < 2) else '.')

    # print(f'end cycle {cycle}')

    run_executions()

    # print(f'x now {x}')
    # print(' ')

    cycle += 1

print(f'X = {x}')
print(f'Signal Strength: {signal_strength_sum}')

for row in crt_rows:
    row_str = ''

    for col in row:
        row_str += col

    print(row_str)
