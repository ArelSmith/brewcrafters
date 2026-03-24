import Link from "next/link";

const Navbar = () => {
  return (
    <header>
      <nav className="bg-green-400">
        {/* Header */}
        <h1 className="text-2xl">
          <Link href="/">Home</Link>
        </h1>
      </nav>
    </header>
  );
};

export default Navbar;
