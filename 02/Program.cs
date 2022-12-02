using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;

namespace AoC2022_02
{
    class Program
    {
        static readonly Dictionary<string, int> moves = new Dictionary<string, int>()
        {
            {"A", 1}, // Rock
            {"B", 2}, // Paper
            {"C", 3}, // Scissors
            {"X", 1}, // Rock       // Lose
            {"Y", 2}, // Paper      // Draw
            {"Z", 3}  // Scissors   // Win
        };

        static string PickMove(string p1Move, string outcome)
        {
            int dictIncrement = 1; // Default Win (+1)

            if (outcome == "Y") // Draw
            {
                return p1Move;
            }

            if (outcome == "X") // Lose (+2)
                dictIncrement = 2;

            int moveVal = moves[p1Move] - 1;
            return moves.ElementAt(moveVal + dictIncrement).Key;
        }

        static bool P1Wins(int p1, int p2)
        {
            bool p1Win = true;
            int scoreTotal = p1 + p2;

            if (scoreTotal == 4)
                p1Win = p1 < p2; // Rock + Scissors
            else if (scoreTotal == 3 || scoreTotal == 5)
                p1Win = p1 > p2; // Rock + Paper || Paper + Scissors
            else {
                Console.WriteLine("Something went wrong!");
                Environment.Exit(0);
            }

            return p1Win;
        }

        static Tuple<int, int> RoundScore(string p1, string p2)
        {
            int p1Score = moves[p1];
            int p2Score = moves[p2];

            // Draw
            if (p1Score.Equals(p2Score))
            {
                return Tuple.Create(p1Score + 3, p2Score + 3);
            }

            bool p1Win = P1Wins(p1Score, p2Score);

            p1Score += p1Win ? 6 : 0;
            p2Score += p1Win ? 0 : 6;

            return Tuple.Create(p1Score, p2Score);
        }

        static void Main(string[] args)
        {
            int p1Part1Total = 0,
                p2Part1Total = 0,
                p1Part2Total = 0,
                p2Part2Total = 0;

            string text = File.ReadAllText(
                Directory.GetCurrentDirectory() + "/input.txt"
            );

            string[] lines = text.Split(
                new string[] { Environment.NewLine },
                StringSplitOptions.None
            );

            foreach (string line in lines)
            {
                string[] lMoves = line.Split(" ");
                Tuple<int, int> results = RoundScore(lMoves[0], lMoves[1]);
                p1Part1Total += results.Item1;
                p2Part1Total += results.Item2;

                results = RoundScore(
                    lMoves[0], PickMove(lMoves[0], lMoves[1])
                );
                p1Part2Total += results.Item1;
                p2Part2Total += results.Item2;
            }

            Console.WriteLine("Part 1:");
            Console.WriteLine(" Player 1: " + p1Part1Total.ToString());
            Console.WriteLine(" Player 2: " + p2Part1Total.ToString());

            Console.WriteLine("Part 2:");
            Console.WriteLine(" Player 1: " + p1Part2Total.ToString());
            Console.WriteLine(" Player 2: " + p2Part2Total.ToString());
        }
    }
}
