package FOnline::MSG;

use strict;
use warnings;

#use FOnline;

BEGIN {
    use Exporter 'import';
    our( @ISA, @EXPORT, @EXPORT_OK, %EXPORT_TAGS, $VERSION );
    $VERSION = '0.3';
    @ISA = qw( Exporter );

    @EXPORT = @EXPORT_OK = qw(
	&srv_LoadMsgFile
	&srv_LoadMsgFileSafe
    );
};

#+++
#> srv_LoadMsgFile
#---
sub srv_LoadMsgFile($)
{
    my $file = shift || die "srv_LoadMsgFile: !file";

    my %msg;
    if( open( FILE, '<', $file ))
    {
	while( <FILE> )
	{
	    chop;
	    s!\r!!g;
	    if( /{([0-9]+)}{}{(.*)}/ )
	    {
		my $id = $1;
		my $text = $2;
		$msg{$id} = $text || '';
	    };
	};
	close( FILE );
    };

    return( %msg );
};

#+++
#> srv_LoadMsgFileSafe
#---
sub srv_LoadMsgFileSafe($)
{
    my $file = shift || die "srv_LoadMsgFileSafe: !file";

    my %msg;
    if( open( FILE, '<', $file ))
    {
	while( <FILE> )
	{
	    chop;
	    s!\r!!g;
	    if( /{([0-9]+)}{}{(.*)}/ )
	    {
		my $id = $1;
		my $text = $2;
		push( @{ $msg{$id} }, $text || '' );
	    };
	};
	close( FILE );
    };

    return( %msg );
};

1;
