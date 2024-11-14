import java.util.Scanner;

public class UserActivity {

    private static boolean isLoggedIn = false;
    
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        
        while (true) {
            System.out.println("Welcome to the system!");
            System.out.println("Please choose an action:");
            System.out.println("1. Login");
            System.out.println("2. Signup");
            System.out.println("3. View Product");
            System.out.println("4. Exit");
            int choice = scanner.nextInt();
            
            switch (choice) {
                case 1:
                    login();
                    break;
                case 2:
                    signup();
                    break;
                case 3:
                    viewProduct();
                    break;
                case 4:
                    System.out.println("Exiting the system. Goodbye!");
                    return;
                default:
                    System.out.println("Invalid choice, please try again.");
            }
        }
    }
    
    public static void login() {
        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter username: ");
        String username = scanner.nextLine();
        System.out.print("Enter password: ");
        String password = scanner.nextLine();
        
        if (username.equals("user") && password.equals("pass")) { // Dummy credentials
            isLoggedIn = true;
            System.out.println("Login successful!");
        } else {
            System.out.println("Invalid credentials, please try again.");
        }
    }
    
    public static void signup() {
        Scanner scanner = new Scanner(System.in);
        System.out.print("Enter desired username: ");
        String username = scanner.nextLine();
        System.out.print("Enter desired password: ");
        String password = scanner.nextLine();
        
        System.out.println("Signup successful! You can now login.");
        // Here, we would typically store the username and password in a database.
    }
    
    public static void viewProduct() {
        if (!isLoggedIn) {
            System.out.println("You need to be logged in to view products.");
            return;
        }
        
        System.out.println("Viewing product details...");
        // Display product details (In a real application, fetch product data from a database)
    }
}
