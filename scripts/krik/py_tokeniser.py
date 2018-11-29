# -*- coding: utf-8 -*-

"""
Python module to tokenise texts.
There are two available tokenisers:
- SimpleTokeniser which uses very simple regular expressions
- RegExpTokeniser which is based on some language-dependent regular 
expressions, available for French (fr) and English (en)


Installation:
=============
Put the module in a directory listed in the Python path.

Usage:
======
Example::
    import py_tokeniser
    # (1) build a tokeniser object 
    # (either a SimpleTokeniser or a RegExpTokeniser)
    ret = py_tokeniser.RegExpTokeniser('fr')
    # (2) tokenise text
    tokens = ret.tokenise(my_french_text)
    # (3) print tokenised text
    print tokens

The module can be used as a command line tool too, for more information
ask for module help::
    python py_tokeniser.py --help

@author: Delphine Bernhard (Delphine.Bernhard@unistra.fr)
@version: 1.3
"""


import codecs, re, sys

__version__ = "1.2"
__author__ = "Delphine Bernhard <Delphine.Bernhard@unistra.fr>"
__date__ = "2005"
__revision__ = "$Id$"

available_languages = ['fr', 'en', 'gsw', 'any', 'gcf']

#The regular expressions here have been inspired from Gregory Grefenstette's 
# Corpora List Message dated Fri, 16 Oct 1998 
#(http://torvald.aksis.uib.no/corpora/1998-4/0035.html)
# and also inspired from TreeTaggerWrapper
always_sep = ur'(\?|¿|!|;|\*|¤|°|\||¦|\(|\)|\\|\[|\]|\{|_|"|“|”|«|»|„|&|#|~|=|—|\+|–|©|―|®|–)'
#Language-dependent regular expressions
begin_sep = {'fr' : ur"(``|`|‘|[cdjlmnst]'|[cdjlmnst]`|[cdjlmnst]’|[cdjlmnst]´|[cdjlmnst]‘|lorsqu'|jusqu'|qu'|lorsqu`|jusqu`|qu`|lorsqu´|jusqu´|qu´|lorsqu’|jusqu’|qu’|lorsqu‘|jusqu‘|qu‘)", \
            'en' : ur"(``|`|‘)", \
            'gsw' : ur"(``|[ds]'(?!r )|[ds]`(?!r )|[ds]’(?!r )|[ds]´(?!r )|[ds]‘(?!r )|z'|z`|z’|z´|z‘)", \
	    'gcf' : ur"(``|`|‘)", \
            'any' : ur"(``|`|‘)"}
end_sep = {'fr' : ur"(-|'|’|:|‚|-ce|-ci|-elle|-elles|-en|-il|-ils|-je|-la|-là|-les|-leur|-lui|-même|-mêmes|-moi|-nous|-on|-toi|-tu|-vous|-y){1}", \
            'en' : ur"(-|'|’|,|:|‚|'[dms]|’[dms]|‘[dms]|`[dms]|´[dms]|'em|'ll|'re|'ve|’em|’ll|’re|’ve|‘em|‘ll|‘re|‘ve|`em|`ll|`re|`ve|´em|´ll|´re|´ve|n't|n’t|n‘t|n`t)", \
            'gsw' : ur"(?<!d)(-|,|:|'[mrs]|’[mrs]|‘[mrs]|`[mrs]|´[mrs])", \
            'gcf' : ur"(-la|'w|-lasa|-y|'y|:)", \
            'any' : ur"(-|'|’|,|:)"}
numbers = {'fr' : ur'(<|>)?([0-9]+[ |.]?)+[0-9]?([,][0-9]+)?', \
            'en' : ur'(\$|£|<|>|¥)?([0-9]+[,]?)+((\.)?([0-9])+)*([-](\w|-|\.)*)*', \
            'gsw' : ur'^(<|>)?([0-9IVXLCDM]+[ |.]?)+[0-9]?([,][0-9]+)?$',\
            'gcf' : ur'(<|>)?([0-9]+[ |.]?)+[0-9]?([,][0-9]+)?',\
            'any' : ur'([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?'}
# pour gcw : même tokéniseur qu'en français pour les nombres
abbrev1 = {'fr' : ur'(st\.|co\.|corp\.|vs\.|e\.g\.|etc\.|ex\.|cf\.|eg\.|fig\.|no\.|jan\.|fev\.|juil\.|sep\.|sept\.|oct\.|nov\.|dec\.|ed\.|eds\.|repr\.|trans\.|vol\.|vols\.|rev\.|est\.|b\.|m\.|bur\.|d\.|r\.|dept\.|mm\.|u\.|mr\.|jr\.|ms\.|mme\.|mrs\.|dr\.|sen\.|gen\.|rev\.|gov\.|al\.|ap\.|apr\.|av\.|ave\.|bd\.|boul\.|mar\.|mer\.|me\.|messrs\.|mlle\.|mme\.|no\.)', \
            'en' : ur'(st\.|co\.|corp\.|vs\.|e\.g\.|etc\.|ex\.|cf\.|eg\.|fig\.|no\.|jan\.|feb\.|mar\.|apr\.|jun\.|jul\.|aug\.|sep\.|sept\.|oct\.|nov\.|dec\.|ed\.|eds\.|repr\.|trans\.|vol\.|vols\.|rev\.|est\.|b\.|m\.|bur\.|d\.|r\.|dept\.|mm\.|u\.|mr\.|jr\.|ms\.|mme\.|mrs\.|dr\.|sen\.|gen\.|rev\.|gov\.|al\.|mt\.)', \
            'gsw' : ur'(co\.|ca\.|corp\.|vs\.|e\.g\.|etc\.|ex\.|cf\.|eg\.|jan\.|feb\.|mar\.|apr\.|jun\.|jul\.|aug\.|sep\.|sept\.|oct\.|nov\.|dec\.|ed\.|eds\.|repr\.|trans\.|vol\.|vols\.|rev\.|est\.|b\.|m\.|bur\.|d\.|r\.|dept\.|mm\.|u\.|mr\.|jr\.|ms\.|mme\.|mrs\.|dr\.|frz\.|bask\.|pl\.|off\.|dt\.|bzw\.|Bd\.|Allg\.)', \
	    'gcf' : ur'(co\.|ca\.|corp\.|vs\.|e\.g\.|etc\.|ex\.|cf\.|eg\.|jan\.|feb\.|mar\.|apr\.|jun\.|jul\.|aug\.|sep\.|sept\.|oct\.|nov\.|dec\.|ed\.|eds\.|repr\.|trans\.|vol\.|vols\.|rev\.|est\.|b\.|m\.|bur\.|d\.|r\.|dept\.|mm\.|u\.|mr\.|jr\.|ms\.|mme\.|mrs\.|dr\.|frz\.|bask\.|pl\.|off\.|dt\.|bzw\.|Bd\.|Allg\.)', \
            'any' : ur'(co\.|corp\.|vs\.|e\.g\.|etc\.|ex\.|cf\.|eg\.|jan\.|feb\.|mar\.|apr\.|jun\.|jul\.|aug\.|sep\.|sept\.|oct\.|nov\.|dec\.|ed\.|eds\.|repr\.|trans\.|vol\.|vols\.|rev\.|est\.|b\.|m\.|bur\.|d\.|r\.|dept\.|mm\.|u\.|mr\.|jr\.|ms\.|mme\.|mrs\.|dr\.)'}
# pour gcw : même tokéniseur qu'en français pour les abbréviations
abbrev2 = ur'(\w\.(\w\.)*)'
abbrev3 = ur'([A-Z]\.[A-Z][bcdfghi-np-tvxz]+\.)'
url = ur'([http://]?([^ .]+\.){2,}([^ ])+)'
email = ur'[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}'
#Token types with their string representation
types = {'word' : 0, 'separator' : 1, 'number' : 2, \
              'abbreviation' : 3, 'url' : 4, 'email' : 5}

#==============================================================================
class TokeniserIOError(Exception):
    """This exception can occur if there is an input-output problem"""
    
    def __init__(self, value):
        Exception.__init__(self)
        self.value = value
    
    def __str__(self):
        return repr(self.value)

#==============================================================================
class Paragraph:
    """
    Class representing a paragraph
    @ivar  sentences: Sentences contained in the paragraph
    @type sentences: list of Sentence objects
    """
    
    def __init__(self):
        self.sentences = []

    def get_sentences(self):
        """
        Returns the list of sentences
        @return: List of sentences
        @rtype:  List of Sentence objects
        """
        return self.sentences
        
    def add_sentence(self, sentence):
        """
        Adds a Sentence to the list of sentences
        
        @param sentence: sentence to add in the paragraph
        @type sentence: Sentence
        """
        self.sentences.append(sentence)
        
    def remove_last_sentence(self):
        """
        Removes the last sentence from the list of sentences
        """
        self.sentences.pop()
        
    def get_contents(self):
        s = u'\n'
        strs = [tok.get_contents() for tok in self.sentences]
        return s.join(strs)
   
    def __str__(self, encoding="utf-8"):
        return self.__unicode__().encode(encoding)
    
    def __unicode__(self):
        return self.get_contents()

#==============================================================================
class Sentence: 
    """
    Class representing a sentence
    @ivar  words: words contained in the sentence
    @type words: list of Word objects
    """
    
    def __init__(self):
        self.words = []

    def get_words(self):
        """
        Returns the list of words
        
        @return: List of words
        @rtype:  List of Word objects
        """
        return self.words
            
    def get_length(self):
        """
        Returns the number of words in the sentence
        
        @return: Number of words in the sentence
        @rtype:  integer
        """
        return len(self.words)
    
    def add_word(self, word):
        """
        Adds a Word to the list of words
        
        @param word: word to add in the sentence
        @type word: Word
        """
        w = str(word)
        if len(w) > 0 and not w.isspace():
            self.words.append(word)
            
    def get_contents(self):
        s = u' '
        strs = [tok.get_contents() for tok in self.words]
        return s.join(strs)
    
    def __str__(self, encoding="utf-8"):
        return self.__unicode__().encode(encoding)
    
    def __unicode__(self):
        return self.get_contents()

#==============================================================================
class Word:
    """
    Class representing a word
    @ivar  word: word
    @type word: string
    @ivar  t_type: token type
    @type t_type: integer
    """
    
    def __init__(self, contents, _type = 0):
        self.word = contents
        self.t_type = _type
    
    def __str__(self, encoding="utf-8"):
        return self.__unicode__().encode(encoding)
    
    def __unicode__(self):
        return self.word
    
    def get_contents(self):
        return self.word

#==============================================================================
class Text:
    """
    Class representing a text : it contains paragraphs
    @ivar  paragraphs: paragraphs contained in the text
    @type paragraphs: list of Paragraph objects
    """
    
    def __init__(self):
        self.paragraphs = []

    def add_paragraph(self, pt) :
        """
        Adds a Paragraph to the list of paragraphs
        
        @param pt: paragraph to add in the text
        @type pt: Paragraph
        """
        self.paragraphs.append(pt)
    
    def get_paragraphs(self) :
        """
        Returns the list of paragraphs
        
        @return: List of paragraphs
        @rtype:  List of Paragraph objects
        """
        return self.paragraphs

    def get_sentences(self):
        """
        Returns the list of sentences
        
        @return: List of sentences
        @rtype:  List of Sentence objects
        """
        sentences = []
        for p in self.paragraphs:
            for s in p.get_sentences():
                sentences.append(s)
        return sentences

    def get_words(self) :
        """
        Returns the list of words
        
        @return: List of words
        @rtype:  List of Word objects
        """
        words = []
        for s in self.get_sentences():
            for w in s.get_words():
                words.append(w)
        return words
    
    def get_contents(self):
        res = u''
        for p in self.paragraphs:
            sentences = p.get_sentences()
            if len(sentences) > 0:
                for s in sentences:
                    res = res + s.get_contents().rstrip()
                    res = res.rstrip() + u'\n'
                res = res + u'\n'
        return res
    
    def __str__(self, encoding="utf-8"):
        return self.__unicode__().encode(encoding)
    
    def __unicode__(self):
        return self.get_contents()
    
    def to_XML(self) :
        """
        Returns an XML representation of the text's tokens
        
        @return: XML representation of the text's tokens
        @rtype:  string
        """
        res = ''
        pIndex = 0
        sIndex = 0
        for p in self.paragraphs:
            sentences = p.get_sentences()
            if len(sentences) > 0:
                res += "<p id=\"p-"+str(pIndex)+"\">"+'\n'
                pIndex += 1
                for s in sentences:
                    words = s.get_words()
                    if len(words) > 0:
                        res += "\t<s id=\"s-"+str(sIndex)+"\"> "
                        sIndex += 1
                        for w in words:
                            res += "<w>"+w.get_contents()+"</w> "
                        res += "</s>"+'\n'
                res += "</p>"+'\n'
        return res
    
    def to_lines(self):
        """
        Returns an string representation of the text's tokens with one token per line
        
        @return: string representation of the text's tokens with one token per line
        @rtype:  string
        """
        res = ''
        for p in self.paragraphs:
            sentences = p.get_sentences()
            if len(sentences) > 0:
                for s in sentences:
                    words = s.get_words()
                    if len(words) > 0:
                        for w in words:
                            res += w.get_contents().rstrip() + '\n'
                        res += '\n'
                res += '\n'
        return res

#==============================================================================
class Tokeniser(object):
    """Base class for all tokenisers"""
    
    def __init__(self):
        pass
    
    def tokenise(self, text) :
        """
        Tokenises a text
        """
        pass
    
    def add_word(self, word, sentence, t_type=0):
        """
        Adds a Word to the current sentence
        
        @param word: word to add to the sentence
        @type word: string
        @param sentence: sentence to which the word will be added
        @type sentence: Sentence
        @param t_type: word type
        @type t_type: integer
        @return: sentence
        @rtype:  Sentence
        """
        wt = Word(word, t_type)
        sentence.add_word(wt)
        return sentence
    
#==============================================================================
class SimpleTokeniser(Tokeniser) :
    """ 
    SimpleTokeniser which uses very simple regular expressions
    """
    
    def __init__(self):
        self.sentence_re = re.compile(ur'([.!?…]+)\s+', re.IGNORECASE | re.UNICODE)
        self.delim_re = re.compile(r'[.!?…]+')
        self.word_re1 = re.compile(r'(\w+)', re.IGNORECASE | re.UNICODE)
        self.word_re2 = re.compile(r'([^\w\s]+)', re.IGNORECASE | re.UNICODE)
    
    def tokenise(self, text):
        """
        Tokenises a text
        @param text: text to tokenise
        @type text: string
        @return: Text object
        @rtype:  Text
        """
        t = Text()
        paragraphs = text.split('\n')
        for p in paragraphs:
            pa = Paragraph()
            t.add_paragraph(pa)
            sentences = self.sentence_re.split(p)
            se = Sentence()
            for s in sentences:
                if not self.delim_re.match(s) is None :
                    wt = Word(s)
                    se.add_word(wt)
                else:
                    se = Sentence()
                    pa.add_sentence(se)
                    s = self.word_re1.sub(r' \1 ', s)
                    s = self.word_re2.sub(r' \1 ', s)
                    words = s.split()
                    for w in words:
                        wt = Word(w)
                        se.add_word(wt)
        return t

#==============================================================================
class RegExpTokeniser(Tokeniser) : 
    """ 
    Tokeniser based on more elaborate regular expressions which are language dependent
    @ivar  lang: language used to select regular expressions
    @type lang: string
    """
    
    def __init__(self, lang):
        """
        Constructor for the RegExpTokeniser object
        @param lang: language of the text (used to select specific regular expressions)
        @type lang: string
        """
        if not lang in available_languages:
            self.lang  = 'any'
        else:
            self.lang = lang
        self.ab1_re = re.compile(abbrev1[self.lang], re.IGNORECASE)
        self.ab2_re = re.compile(abbrev2)
        self.ab3_re = re.compile(abbrev3)
        self.num_re = re.compile(numbers[self.lang])
        self.url_re = re.compile(url)
        self.mail_re = re.compile(email, re.IGNORECASE)
    
    def tokenise(self, text):
        """
        Tokenises a text
        @param text: text to tokenise
        @type text: string
        @return: Text object
        @rtype:  Text
        """
        t = Text()
        regex = always_sep
        text = RegExpTokeniser._handle_always_sep(regex, text)
        regex = end_sep[self.lang]
        text = RegExpTokeniser._handle_end_sep(regex, text)
        regex = begin_sep[self.lang]
        text = RegExpTokeniser._handle_begin_sep(regex, text)
        text = RegExpTokeniser._handle_sometimes_sep(text)
        paragraphs = text.split('\n')
        p = Paragraph()
        t.add_paragraph(p)
        s = Sentence()
        p.add_sentence(s)
        paragraph = ""
        for i in range(len(paragraphs)):
            paragraph += paragraphs[i];
            if i < (len(paragraphs) - 1) :
                p = self._build_sentences(paragraph, p, s)
                p = Paragraph()
                t.add_paragraph(p)
                s = Sentence()
                p.add_sentence(s)
                paragraph = ""
            else:
                p = self._build_sentences(paragraph, p, s)
        return t
    
    def _build_sentences(self, paragraph, p, s):
        tokens = paragraph.split()
        token = ""
        i = 0
        while i < len(tokens):
            token = tokens[i]
            point = token.find('.') != -1
            threePoints = token.find(u'…') != -1 or token.find(u"...") != -1
            comma = token.find(',')
            mark = cmp(token, "?") == 0 or cmp(token, "!") == 0
            dash = token.find('/')
            ab1_match = 0
            ab2_match = 0
            ab3_match = 0
            num_match = 0
            url_match = 0
            mail_match = 0
            if point:
                ab1_match = not self.ab1_re.match(token) is None
                ab2_match = not self.ab2_re.match(token) is None
                ab3_match = not self.ab3_re.match(token) is None
                url_match = not self.url_re.match(token) is None
                mail_match = not self.mail_re.match(token) is None
            num_match = not self.num_re.match(token) is None
            if mark :
                s = self.add_word(token, s, types['separator'])
                if i < (len(tokens) - 1):
                    s = Sentence()
                    p.add_sentence(s)
            elif comma != -1 and (not num_match or comma == (len(token) - 1)):
                if num_match :
                    s = self.add_word(token[0:comma], s, types['number'])
                else :
                    s = self.add_word(token[0:comma], s, self._get_type(token[0:comma]))
                s = self.add_word(",", s, types['separator'])                    
            elif  (point or threePoints) \
              and not ab1_match \
              and not ab2_match \
              and not ab3_match \
              and not num_match \
              and not url_match \
              and not mail_match:
                if (point and token.rfind('.') == (len(token) - 1)) \
                  or (threePoints and token.rfind(u'...') == (len(token) - 1)) \
                  or (threePoints and token.rfind(u'…') == (len(token) - 1)) :
                    token = token.replace(u'.', u'')
                    token = token.replace(u'…', u'')
                    closePunct = 0
                    if i < (len(tokens) - 1) :
                        closePunct = cmp(tokens[i+1] , u'"') == 0 \
                                or cmp(tokens[i+1], u'”') == 0 \
                                or cmp(tokens[i+1], u')') == 0 \
                                or cmp(tokens[i+1], u']') == 0
                    s = self.add_word(token, s, self._get_type(token))
                    if not threePoints:
                        s = self.add_word(u'.', s, types['separator'])
                    else:
                        s = self.add_word(u"…", s, types['separator'])
                    if closePunct :
                        s = self.add_word(tokens[i+1], s, types['separator'])
                        i += 1
                    if i < (len(tokens) - 1) :
                        s = Sentence()
                        p.add_sentence(s)
                else:
                    word =''
                    sep = ''
                    for j in range(len(token)):
                        if token[j] == u'.' or token[j] == u'…':
                            sep = sep + token[j]
                            if len(word) > 0 :
                                s = self.add_word(word, s, self._get_type(word))
                                word = u''
                        else :
                            word = word + token[j]
                            if len(sep) > 0:
                                s = self.add_word(sep, s, types['separator'])
                                sep = u''
                    s = self.add_word(word, s, self._get_type(word))
            elif dash != -1 and not url_match:
                t1 = token[0:dash]
                t2 = token[dash+1:]
                if t1.isdigit() and t2.isdigit() :
                    s = self.add_word(token, s, self._get_type(token))
                else:
                    s = self.add_word(t1, s, self._get_type(t1))
		    print ("adding slash")
                    s = self.add_word('/', s, types['separator'])
                    s = self.add_word(t2, s, self._get_type(t2))
            else : 
                if num_match :
                    s = self.add_word(token, s, types['number'])
                elif ab1_match or ab2_match or ab3_match :
                    s = self.add_word(token, s, types['abbreviation'])
                elif url_match :
                    s = self.add_word(token, s, types['url'])
                elif mail_match :
                    s = self.add_word(token, s, types['email'])
                else :
                    s = self.add_word(token, s)
            i += 1
        return p
    
    @staticmethod
    def _handle_always_sep(regexp, text) :
        p = re.compile(regexp, re.IGNORECASE|re.UNICODE)
        text = p.sub(r' \1 ', text)
        return text

    @staticmethod
    def _handle_begin_sep(regexp, text):
        p = re.compile(r'^' + regexp, re.IGNORECASE)
        text = p.sub(r'\1 ', text)
        p = re.compile(r'[\A\b]' + regexp, re.IGNORECASE)
        text = p.sub(r'\1 ', text)
        p = re.compile(r'([^\w\b])' + regexp, re.IGNORECASE|re.UNICODE)
        text = p.sub(r'\1\2 ', text)
        p = re.compile("\s(-)", re.IGNORECASE)
        text = p.sub(r' \1 ', text)
        return text

    @staticmethod
    def _handle_end_sep(regexp, text):
        p = re.compile(regexp+r'([^\w/])', re.IGNORECASE |re.UNICODE)
        text = p.sub(r' \1\2', text)
        return text

    @staticmethod
    def _handle_sometimes_sep(text) :
        p = re.compile('([\s\b][^/\s\.\d\b:]+)(/+)([^/\s\.\d\b]*[\b\s\./])', \
                                  re.IGNORECASE|re.UNICODE)
        text = p.sub(r'\1  \2 \3', text)
        text = p.sub(r'\1  \2 \3', text)
        return text
        
    def _get_type(self, text):
        ab1_match = not self.ab1_re.match(text) is None
        ab2_match = not self.ab2_re.match(text) is None
        ab3_match = not self.ab3_re.match(text) is None
        url_match = not self.url_re.match(text) is None
        mail_match = not self.mail_re.match(text) is None
        num_match = not self.num_re.match(text) is None
        if num_match :
            return types['number']
        elif ab1_match or ab2_match or ab3_match :
            return types['abbreviation']
        elif url_match :
            return types['url']
        elif mail_match :
            return types['email']
        else :
            return types['word']
    
#==============================================================================
class FileTokeniser:
    """ 
    Class which makes it possible to tokenise a whole txt file
    """
    
    def __init__(self, input_file, language, encoding):
        self.input_file = input_file
        self.encoding = encoding
        self.t = None
        self.tokeniser = RegExpTokeniser(language)

    def tokenise(self) :
        """
        @deprecated: renamed as tokenise_file because FileTokeniser
                     is not a subclass of Tokeniser anymore
        """
        return self.tokenise_file()

    def tokenise_file(self) :
        self.t = Text()
        try :
            f = codecs.open(self.input_file, 'r', self.encoding)
            lines = f.readlines()
            text = ''
            text = text.join(lines)
            self.t = self.tokeniser.tokenise(text)
            f.close()
        except IOError, (ErrorMessage):
            raise TokeniserIOError(ErrorMessage)
        return self.t

    def write_result(self, output_format):
        try :
            f = codecs.open(self.input_file +'.tok', 'w', self.encoding)
            f.write(self._get_output(output_format))
            f.close()
        except IOError, (ErrorMessage):
            raise TokeniserIOError(ErrorMessage)

    def _get_output(self, output_format) :
        if output_format == 'space' :
            return self.t.get_contents()
        elif output_format == 'xml' :
            return self.t.to_XML()
        elif output_format == 'lines':
            return self.t.to_lines()
        return self.t.get_contents()
        
def print_usage():
    print ("py_tokeniser.py [-f format]    <language> <encoding> "
                +"<filename>");
    print(" + format is the output format:");
    print("    space - token1 token2 (default)");
    print("    xml   - <w>token</w>");
    print("    lines - token1 [NEWLINE] token2");
    print(" + language is the language in which the file"
                        +" is written [fr or en]");
    print(" + encoding is the file encoding");
    print(" + filename is the name of the file to tokenise");


if __name__ == '__main__':
    output_format = "space"
    if len(sys.argv) < 3:
        print_usage()
        sys.exit(0)
    else:
        k = 1
        print sys.argv
        if sys.argv[1] == '-f':
            output_format = sys.argv[2]
            k = 3
        ft = FileTokeniser(sys.argv[k+2], sys.argv[k], sys.argv[k+1])
        try:
            ft.tokenise()
            ft.write_result(output_format)
        except TokeniserIOError, error:
            print "Tokeniser I/O error : %s" % (str(error))