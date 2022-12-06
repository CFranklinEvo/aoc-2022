Imports System

Module Program
    Sub Main(args As String())
        Dim last4(3) As Char
        Dim last14(14) As Char

        Dim inputString As String
        inputString = IO.File.ReadAllText("./input.txt")

        Dim index As Integer = 1
        Dim hasStart As Boolean = False

        For Each element As Char In inputString
            last4 = ShiftArray(last4, 3)
            last4(3) = element

            last14 = ShiftArray(last14, 13)
            last14(13) = element

            If index >= 4 And Not hasStart Then
                Dim isUnique As Boolean = last4.Distinct().ToArray().Count = 4

                If isUnique Then
                    Console.WriteLine(last4)
                    Console.WriteLine("Part 1: " & index)
                    hasStart = True
                End If
            End If

            If index >= 14 Then
                Dim isUnique As Boolean = last14.Distinct().ToArray().Count = 14

                If isUnique Then
                    Console.WriteLine(last14)
                    Console.WriteLine("Part 2: " & index)
                    Exit For
                End If
            End If

            index += 1
        Next
    End Sub

    Function ShiftArray(charArr As Char(), length As Integer) As Char()
        Dim newCharArr(length) As Char

        For index As Integer = 1 To length
            newCharArr(index - 1) = charArr(index)
        Next

        ShiftArray = newCharArr
    End Function
End Module
