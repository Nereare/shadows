# Book of Shadows &ndash; PHP Style Guide

> The keywords "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED",  "MAY", and "OPTIONAL" in this document are to be interpreted as described in [RFC 2119](http://www.ietf.org/rfc/rfc2119.txt).

These guidelines are based upon [PSR-12: Extended Coding Style](https://www.php-fig.org/psr/psr-12/).

For this repository, whenever these guidelines contradicts the PSR-12, use these guidelines as rule. When these guidelines lack definitions where the PSR-12 offers, them, the PSR-12 takes effect.

<!-- TOC depthFrom:2 depthTo:4 withLinks:1 updateOnSave:1 orderedList:0 -->

- [0. General Principles](#0-general-principles)
	- [0.1. Names](#01-names)
		- [0.1.1. Class Names](#011-class-names)
		- [0.1.2. Method Names](#012-method-names)
		- [0.1.3. Variable Names](#013-variable-names)
		- [0.1.4. Constant Names](#014-constant-names)
		- [0.1.5. Index Names](#015-index-names)
	- [0.2. Filenames](#02-filenames)
		- [0.2.1. Class Filenames](#021-class-filenames)
- [1. Files](#1-files)
	- [1.1. Character encoding](#11-character-encoding)
	- [1.2. Line endings](#12-line-endings)
	- [1.3. File Ending Newline](#13-file-ending-newline)
	- [1.4. Opening PHP Tag](#14-opening-php-tag)
	- [1.5. Closing PHP Tag](#15-closing-php-tag)
	- [1.6. Declaration Order](#16-declaration-order)
		- [1.6.1. Declaration Blank Lines](#161-declaration-blank-lines)
		- [1.6.2. `<?php` Exception](#162-php-exception)
	- [1.7. PHP in HTML](#17-php-in-html)
- [2. Lines](#2-lines)
	- [2.1. Hard Limits](#21-hard-limits)
	- [2.2. Soft Limits](#22-soft-limits)
	- [2.3. Trailing White Spaces](#23-trailing-white-spaces)
	- [2.4. Blank Lines](#24-blank-lines)
	- [2.5. Statements per Line](#25-statements-per-line)
- [3. Identing](#3-identing)
	- [3.1. Identing Lenght](#31-identing-lenght)
	- [3.2. Tabs](#32-tabs)
- [4. Keywords](#4-keywords)
	- [4.1. Reserved Keywords](#41-reserved-keywords)
	- [4.2. Abbreviated Keywords](#42-abbreviated-keywords)
	- [4.3. Import Statements](#43-import-statements)
		- [4.3.1. Namespace Reference](#431-namespace-reference)
		- [4.3.2. Namespace Length](#432-namespace-length)
- [5. Classes, Properties, and Methods](#5-classes-properties-and-methods)
	- [5.1. Opening Braces](#51-opening-braces)
	- [5.2. Closing Braces](#52-closing-braces)
		- [5.2.1. Empty Classes and Methods](#521-empty-classes-and-methods)
	- [5.3. Long `implement` and `extend` Lists](#53-long-implement-and-extend-lists)
	- [5.4. Using Traits](#54-using-traits)
	- [5.5. Instantiating](#55-instantiating)
- [6. Properties and Constants](#6-properties-and-constants)
	- [6.1. Visibility Declaration](#61-visibility-declaration)
	- [6.2. `var` Keyword](#62-var-keyword)
	- [6.3. Property Names](#63-property-names)
- [7. Methods and Functions](#7-methods-and-functions)
	- [7.1. Visibility Declaration](#71-visibility-declaration)
	- [7.2. Method Names](#72-method-names)
	- [7.3. Opening Brace](#73-opening-brace)
	- [7.4. Arguments](#74-arguments)
		- [7.4.1. Parenthesis](#741-parenthesis)
		- [7.4.2. Arguments With Defaults](#742-arguments-with-defaults)
		- [7.4.3. Long Argument Lists](#743-long-argument-lists)
		- [7.4.4. Argument Types](#744-argument-types)
		- [7.4.5. Nullable Arguments](#745-nullable-arguments)
		- [7.4.6. Other Arguments](#746-other-arguments)
	- [7.5. `abstract`, `final`, and `static`](#75-abstract-final-and-static)
	- [7.6. Method and Function Calls](#76-method-and-function-calls)
		- [7.6.1. Parenthesis](#761-parenthesis)
		- [7.6.2. Argument Lists](#762-argument-lists)
		- [7.6.3. Long Argument Lists](#763-long-argument-lists)
- [8. Control Structures](#8-control-structures)
	- [8.1. General Rules](#81-general-rules)
		- [8.1.1. Parenthesis](#811-parenthesis)
		- [8.1.2. Braces](#812-braces)
		- [8.1.3. Body](#813-body)
	- [8.2. `if`, `elseif`, and `else`](#82-if-elseif-and-else)
		- [8.2.1. Multiline Exception](#821-multiline-exception)
		- [8.2.2. Long Expressions](#822-long-expressions)
	- [8.3. `switch`, `case`, and `break`](#83-switch-case-and-break)
		- [8.3.1. Long Expressions](#831-long-expressions)
	- [8.4. `while` and `do while`](#84-while-and-do-while)
		- [8.4.1. Long Expressions](#841-long-expressions)
	- [8.5. `for`](#85-for)
	- [8.6. `foreach`](#86-foreach)
	- [8.7. `try`, `catch`, and `finally`](#87-try-catch-and-finally)
		- [8.7.1. Short `catch` or `finally` Bodies](#871-short-catch-or-finally-bodies)
- [9. Operators](#9-operators)
	- [9.1. Unary Operators](#91-unary-operators)
	- [9.2. Binary Operators](#92-binary-operators)
	- [9.3. Ternary Operators](#93-ternary-operators)
- [10. Closures](#10-closures)

<!-- /TOC -->

## 0. General Principles

When this guide referes to "PHP files", the rules also apply to any other file that includes PHP code into it.

### 0.1. Names
When the name includes all-caps abbreviations (*i.e.* UUID), the abbreviation must be used with lowercase (*i.e.* uuid), unless the casing demands first-letter capitalization (*e.g.* `getUuid` for methods or `UuidException` for classes).

See specific capitalization rules below.

#### 0.1.1. Class Names
Class names MUST comply to `PascalCase`.

#### 0.1.2. Method Names
Method names MUST comply to `camelCase`.

#### 0.1.3. Variable Names
Variable names MUST comply to all-lower-case `snake_case`.

#### 0.1.4. Constant Names
Constant name MUST comply to all-upper-case `SCREAMING_SNAKE_CASE`.

#### 0.1.5. Index Names
When indexes are not numeric, they MUST comply to all-lower-case `kebab-case`.

### 0.2. Filenames
Filenames, except as noted below, MUST comply to all-lower-case `kebab-case`.

#### 0.2.1. Class Filenames
Files belonging to the abstract logic (*i.e.* the files under the `src/` folder, the files for the `Nereare\Shadows` namespace) MUST comply to the same rules as [Classes](#011-class-names), *i.e.* `PascalCase`.

## 1. Files

### 1.1. Character encoding
All PHP files MUST be set to UTF-8.

### 1.2. Line endings
All PHP files MUST use the Unix LF (linefeed) line ending only.

### 1.3. File Ending Newline
All PHP files MUST end with a non-blank line, terminated with a single LF.

### 1.4. Opening PHP Tag
When the opening `<?php` tag is on the first line of the file, it MUST be on its own line with no other statements unless it is a file containing markup outside of PHP opening and closing tags.

### 1.5. Closing PHP Tag
The closing `?>` tag MUST be omitted from files containing only PHP.

### 1.6. Declaration Order
Each block MUST be in the order listed below, although blocks that are not relevant may be omitted:

1. Opening `<?php` tag.
2. File-level docblock.
3. One or more `declare` statements.
4. The `namespace` declaration of the file.
5. One or more class-based `use` import statements.
6. One or more function-based `use` import statements.
7. One or more constant-based `use` import statements.
8. The remainder of the code in the file.

#### 1.6.1. Declaration Blank Lines
If present, each of the blocks above MUST be separated by a single blank line, and MUST NOT contain a blank line.

#### 1.6.2. `<?php` Exception
Only the opening `<?php` tag MUST NOT be separated by a blank line.

### 1.7. PHP in HTML
When a file contains a mix of HTML and PHP, any of the above sections may still be used. If so, they MUST be present at the top of the file, even if the remainder of the code consists of a closing PHP tag and then a mixture of HTML and PHP.

## 2. Lines

### 2.1. Hard Limits
There MUST NOT be a hard limit on line length.

### 2.2. Soft Limits
The soft limit on line length MUST be 120 characters.

Lines SHOULD NOT be longer than 80 characters; lines longer than that SHOULD be split into multiple subsequent lines of no more than 80 characters each.

### 2.3. Trailing White Spaces
There MUST NOT be trailing whitespace at the end of lines.

### 2.4. Blank Lines
Blank lines MAY be added to improve readability and to indicate related blocks of code except where explicitly forbidden.

### 2.5. Statements per Line
There MUST NOT be more than one statement per line.

## 3. Identing

### 3.1. Identing Lenght
Code MUST use an indent of **2** spaces for each indent level.

### 3.2. Tabs
Code MUST NOT use tabs for indenting.

## 4. Keywords

### 4.1. Reserved Keywords
All PHP reserved keywords and types ([1], [2]) MUST be in lower case.

Any new types and keywords added to future PHP versions MUST be in lower case.

### 4.2. Abbreviated Keywords
Short form of type keywords MUST be used. *I.e.* `bool` instead of `boolean`, `int` instead of `integer`.

### 4.3. Import Statements

#### 4.3.1. Namespace Reference
Import statements MUST never begin with a leading backslash (*i.e.* `Foo\Bar`) as they must always be fully qualified.

#### 4.3.2. Namespace Length
Compound namespaces with a depth of more than two MUST NOT be used. Therefore the following is the maximum compounding depth allowed:

```php
<?php
use Vendor\Package\SomeNamespace\{SubnamespaceOne\ClassA,
                                  SubnamespaceOne\ClassB,
                                  SubnamespaceTwo\ClassY,
                                  ClassZ,
};
```

And the following would not be allowed:

```php
<?php

use Vendor\Package\SomeNamespace\{SubnamespaceOne\AnotherNamespace\ClassA,
                                  SubnamespaceOne\ClassB,
                                  ClassZ,
};
?>
```

## 5. Classes, Properties, and Methods

### 5.1. Opening Braces
The opening brace for the block MUST go on the same line as its declaration.

Opening braces MUST NOT be on their own line and MUST NOT be followed by a blank line.

### 5.2. Closing Braces
The closing brace for the block MUST go on the next line after the body.

Any closing brace MUST NOT be followed by any comment or statement on the same line.

Closing braces MUST be on their own line and MUST NOT be preceded by a blank line.

```php
final class Foo extends Bar {
  // Code here...
}
```

#### 5.2.1. Empty Classes and Methods
If the class or method block is empty, the closing brace SHOULD come after the opening brace, in the same line. When this is the case, ther MUST NOT be any characters between the braces.

Comments in empty blocks SHOULD be on a line of their own.

```php
public class Foo extends Exception {}

private function bar() {
  // Some comment here...
}
```

### 5.3. Long `implement` and `extend` Lists
Lists of `implement`s and, in the case of interfaces, `extend`s MAY be split across multiple lines, where each subsequent line is indented once.

When doing so, the first item in the list MUST be on the same line, and the following items MUST be indented to match the first item.

```php
class ClassName extends ParentClass implements \ArrayAccess,
                                               \Countable,
                                               \Serializable {
  // Code here...
}
```

### 5.4. Using Traits
The `use` keyword used inside the classes to implement traits MUST be declared on the next line after the opening brace.

Each individual trait that is imported into a class MUST be included one-per-line and each inclusion MUST have its own `use` import statement.

When the class has nothing after the `use` import statement(s), the class closing brace MUST be on the next line after the `use` import statement(s).

Otherwise, the `use`s" block MUST have a blank line after the `use` import statements.

### 5.5. Instantiating
When instantiating a new class, parentheses MUST always be present even when there are no arguments passed to the constructor.

```php
new Foo();
```

## 6. Properties and Constants

### 6.1. Visibility Declaration
Visibility MUST be declared on all properties.

Visibility MUST be declared on all constants.

### 6.2. `var` Keyword
The `var` keyword MUST NOT be used to declare a property.

There MUST NOT be more than one property declared per statement.

There MUST be a space between type declaration and property name.

### 6.3. Property Names
Property names MUST NOT be prefixed with a single underscore to indicate protected or private visibility. That is, an underscore prefix explicitly has no meaning.

A property declaration looks like the following:

```php
public $foo = null;
public static int $bar = 0;
```

## 7. Methods and Functions

### 7.1. Visibility Declaration
Visibility MUST be declared on all methods.

### 7.2. Method Names
Method names MUST NOT be prefixed with a single underscore to indicate protected or private visibility. That is, an underscore prefix explicitly has no meaning.

### 7.3. Opening Brace
The opening brace MUST go after the method"s name and arguments, and the closing brace MUST go on the next line following the body.

### 7.4. Arguments
In the argument list, there MUST NOT be a space before each comma, and there MUST be one space after each comma.

#### 7.4.1. Parenthesis
There MUST NOT be a space after the opening parenthesis, and there MUST NOT be a space before the closing parenthesis.

#### 7.4.2. Arguments With Defaults
Method and function arguments with default values MUST go at the end of the argument list.

#### 7.4.3. Long Argument Lists
Argument lists MAY be split across multiple lines. When doing so, the first item in the list MUST be on the same line, the following items MUST be indented to match the first item, and each following line may contain only one item per line.

When the argument list is split across multiple lines, the closing parenthesis and opening brace MUST be placed together on the same line, after the last argument.

#### 7.4.4. Argument Types
When you have a return type declaration present, there MUST be one space after the colon followed by the type declaration. The colon and declaration MUST be on the same line as the argument list closing parenthesis with no spaces between the two characters.

#### 7.4.5. Nullable Arguments
In nullable type declarations, there MUST NOT be a space between the question mark and the type.

#### 7.4.6. Other Arguments
When using the reference operator `&` before an argument, there MUST NOT be a space after it, with the nullable `?` mark.

There MUST NOT be a space between the variadic three dot operator and the argument name.

When combining both the reference operator and the variadic three dot operator, there MUST NOT be any space between the two of the.

```php
public function aVeryLongMethodName(ClassTypeHint $arg1,
                                    &$arg2,
                                    ?int $arg3
                                    array $arg4 = []) {
    // method body
}
```

### 7.5. `abstract`, `final`, and `static`
When present, the `abstract` and `final` declarations MUST **precede** the visibility declaration.

When present, the `static` declaration MUST come **after** the visibility declaration.

### 7.6. Method and Function Calls
When making a method or function call, there MUST NOT be a space between the method or function name and the opening parenthesis.

#### 7.6.1. Parenthesis
There SHOULD be a space after the opening parenthesis, and there SHOULD be a space before the closing parenthesis, where this will help with readability.

#### 7.6.2. Argument Lists
In the argument list, there MUST NOT be a space before each comma, and there MUST be one space after each comma.

#### 7.6.3. Long Argument Lists
Argument lists MAY be split across multiple lines. When doing so, the first item in the list MUST be on the same line, the following items MUST be indented to match the first item, and each following line may contain only one item per line.

A single argument being split across multiple lines (as might be the case with an anonymous function or array) does not constitute splitting the argument list itself.

## 8. Control Structures
There MUST be one space after the control structure keyword.

### 8.1. General Rules

#### 8.1.1. Parenthesis
There SHOULD be a space after the opening parenthesis. There SHOULD be a space before the closing parenthesis.

#### 8.1.2. Braces
There MUST be one space between the closing parenthesis and the opening brace.

The body MUST be on the next line after the opening brace.

The closing brace MUST be on the next line after the body.

#### 8.1.3. Body
The structure body MUST be indented once.

The body of each structure MUST be enclosed by braces.

### 8.2. `if`, `elseif`, and `else`
An if structure looks like the following:

```php
if ($expr1) {
  // if body
} elseif ($expr2) {
  // elseif body
} else {
  // else body
}
```

The keyword `elseif` SHOULD be used instead of `else if` so that all control keywords look like single words.

#### 8.2.1. Multiline Exception
The bodies of `if`, `elseif`, and `else` MAY be organized like the following only when the body is composed of one single declaration:

```php
if ($expr1) { /* if body */ }
elseif ($expr2) { /* elseif1 body */ }
elseif ($expr3) {
  // elseif2 body
  // when various declarations
} else { /* else body */ }
```

When one of the bodies are composed of more than one declaration, this body MUST be on the next line as the opening brace, and the closing brace on the next line after the body.

#### 8.2.2. Long Expressions
Expressions in parentheses MAY be split across multiple lines. When doing so, the first condition MUST be on the same line of the opening parenthesis, and each subsequent condition MUST be indented to match the first, with one condition per line.

The `||` or `&&` MUST come at the end of the condition line, with one space before it.

The closing parenthesis and opening brace MUST be placed together on the same line with one space between them.

Boolean operators between conditions MUST always be at the beginning or at the end of the line, not a mix of both.

```php
if ($expr1 &&
    $expr2 ||
    $expr3) {
  // if body
}
```

### 8.3. `switch`, `case`, and `break`
A `switch` structure looks like the following. Note the placement of parentheses, spaces, and braces.

The `case` statement MUST be indented once from switch, and the `break` keyword (or other terminating keywords) MUST be indented at the same level as the `case` body.

There MUST be a comment such as `// no break` when fall-through is intentional in a non-empty case body.

```php
switch ($expr) {
  case 0:
    echo "First case, with a break";
    break;
  case 1:
    echo "Second case, which falls through";
    // no break
  case 2:
  case 3:
  case 4:
    echo "Third case, return instead of break";
    return;
  default:
    echo "Default case";
    break;
}
```

#### 8.3.1. Long Expressions
Long expressions follows the same rules as in topic [8.2.2.](#822-long-expressions)

### 8.4. `while` and `do while`
The `while` and `do while` statements looks like the following:

```php
while ($expr) {
  // structure body
}

do {
  // structure body;
} while ($expr);
```

#### 8.4.1. Long Expressions
Long expressions follows the same rules as in topic [8.2.2.](#822-long-expressions)

### 8.5. `for`
A `for` statement looks like the following:

```php
for ($i = 0; $i < 10; $i++) {
  // for body
}

for ($i = 0;
     $i < 10;
     $i++) {
  // for body
}
```

### 8.6. `foreach`
A foreach statement looks like the following:

```php
foreach ($iterable as $key => $value) {
  // foreach body
}
```

### 8.7. `try`, `catch`, and `finally`
A `try-catch-finally` block looks like the following:

```php
try {
  // try body
} catch (FirstThrowableType $e) {
  // catch body
} catch (OtherThrowableType | AnotherThrowableType $e) {
  // catch body
} finally {
  // finally body
}
```

#### 8.7.1. Short `catch` or `finally` Bodies
If the given body is composed of a single declaration, it may be used in the following way:

```php
try {
  // try body
  // with multiline body
} catch (FirstThrowableType $e) {
  // catch body
  // with multiline body
} catch (OtherThrowableType $e) { /* catch body */ }
finally { /* finally body */ }
```

## 9. Operators
When space is permitted around an operator, multiple spaces MAY be used for readability purposes.

### 9.1. Unary Operators
The increment/decrement operators MUST NOT have any space between the operator and operand.

```php
$i++;
++$j;
```

Type casting operators MUST NOT have any space within the parentheses. There MUST be a space between the closing parenthesis and the operand.

```php
$intValue = (int) $input;
```

### 9.2. Binary Operators
All binary arithmetic ([3]), comparison ([4]), assignment ([5]), bitwise ([6]), logical ([7]), string ([8]), and type ([9]) operators MUST be preceded and followed by at least one space.

```php
if ($a === $b) { $foo = $bar ?? $a ?? $b; }
elseif ($a > $b) { $foo = $a + $b * $c; }
```

### 9.3. Ternary Operators
The conditional operator, also known simply as the ternary operator, MUST be preceded and followed by at least one space around both the `?` and `:` characters.

```php
$variable = $foo ? "foo" : "bar";
```

When the middle operand of the conditional operator is omitted, the operator MUST follow the same style rules as other binary comparison ([4]) operators.

```php
$variable = $foo ?: "bar";
```

## 10. Closures
Closures MUST be declared **with** a space after the function keyword, and a space before and after the use keyword.

```php
$closureWithArgs = function ($arg1, $arg2) {
  // body
};

$closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
  // body
};

$closureWithArgsVarsAndReturn = function ($arg1, $arg2) use ($var1, $var2): bool {
  // body
};
```

Otherwise, they follow the same guidelines as with classes and methods.

<!-- References -->
[1]: https://www.php.net/manual/en/reserved.keywords.php
[2]: https://www.php.net/manual/en/reserved.other-reserved-words.php
[3]: https://www.php.net/manual/en/language.operators.arithmetic.php
[4]: https://www.php.net/manual/en/language.operators.comparison.php
[5]: https://www.php.net/manual/en/language.operators.assignment.php
[6]: https://www.php.net/manual/en/language.operators.bitwise.php
[7]: https://www.php.net/manual/en/language.operators.logical.php
[8]: https://www.php.net/manual/en/language.operators.string.php
[9]: https://www.php.net/manual/en/language.operators.type.php
