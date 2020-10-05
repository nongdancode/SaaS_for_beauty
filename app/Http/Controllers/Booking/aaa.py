#Demo homework 2
months = ["January", "February", "March", "April", "May", "June",
          "July", "August", "September", "October", "November", "December"]

# get user input and check input equal to -1 exit the program

check_input = 1
while check_input == 1:
    try:
        user_input = input("Enter the month day, year: ")
    except SyntaxError:
        continue
    if user_input == '-1':
        break
    try:
        find_string = user_input.split()
        check_string = len(user_input)
        if check_string != 3:
            continue
        month = check_string[0]
        day = check_string[1]
        year = check_string[2]
        d, comma = day.split(',')
        # find and display string

        for i in range(12):
            if user_input.find(months[i]) >= 0:
                new_month = str(user_input(i)+1)
                new_date = new_month + "/" + d + "/" + year
                print(new_date)
                break

    except ValueError:
        continue
