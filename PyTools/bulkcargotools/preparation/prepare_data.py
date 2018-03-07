import pandas as pd
import re
from nltk.corpus import stopwords


class PrepareEmails:
    def __init__(self, path_to_csv, remove_stopwords_flag=True):
        self.remove_stopwords_flag = remove_stopwords_flag
        self.df = pd.read_csv(path_to_csv, header=1)
        self.df = self.df.drop(self.df.columns[[0, 5]], axis=1)
        self.df = self.df.reindex_axis(
            self.df.columns[[2, 0, 3, 1, 4]], axis=1)
        self.premature_list = self.make_premature_list_from(self.df)
        self.data = None
        # self.prepare_data(self.premature_list)

    def join_row_to_one_string(self, df_row):
        return pd.Series(df_row.squeeze()).str.cat(sep='\n')

    def make_premature_list_from(self, df):
        output = []
        for index, row in df.iterrows():
            r = row[["From", "To", "Subject", "Body"]]
            output.append(self.join_row_to_one_string(r))
        return output

    def single_newlines(self, input_str):
        regex = r"^ +$"
        regex = re.compile(regex, re.MULTILINE)
        input_str = re.sub(regex, "", input_str)
        input_str = "\n".join(
            [line for line in input_str.splitlines()])
        return re.sub(r'\n+', '\n', input_str).strip()

    def remove_unnecessary_characters(self, input_str):
        regex = r"(?<=\D),|<file.+>|\(|\)|^-|(\.\s+)|-{2,}|[^(a-z)(A-Z)(\d+ \d+)(\d+,\d+)(\-)(\/)(.+@.+\..+)(%)(')(’)]|\.,|['’][sS]|(?<=[a-zA-Z]{4})/(?=[a-zA-Z]{4})|\+ |-$"
        regex = re.compile(regex, re.MULTILINE)
        return re.sub(regex, " ", input_str)

    def multiple_blanks_to_one(self, input_str):
        output = re.sub(r" +", " ", input_str)
        return output

    def format_numbers(self, input_str):
        # Remove blanks
        regex = r"(?<=\d) (?=\d)"
        regex = re.compile(regex, re.MULTILINE)
        output = re.sub(regex, "", input_str)
        # Remove 1000 separators (",")
        regex = r"\d+,\d+,\S+|\d+,\d{3,}"
        regex = re.compile(regex, re.MULTILINE)
        output = regex.sub(self.strip_commas_from_match, output)
        # Remove 1000 separators (".")
        regex = r"\d+\.\d+\.\S+|\d+\.\d{3,}"
        regex = re.compile(regex, re.MULTILINE)
        output = regex.sub(self.strip_dots_from_match_and_add_dot_delimiter, output)
        # Commas to points as delimiter
        regex = r"(?<=\d),(?=\d{1,2}\D)"
        regex = re.compile(regex, re.MULTILINE)
        output = re.sub(regex, ".", output)
        return output

    def strip_commas_from_match(self, m):
        return m.group(0).replace(",", "")

    def strip_dots_from_match_and_add_dot_delimiter(self, m):
        x = m.group(0).replace(".", "")
        x = x.replace(",", ".")
        return x

    def apply_line_by_line(self, input_str, method):
        output_list = []
        for line in input_str.split("\n"):
            substituted = method(line)
            output_list.append(substituted)
        return "\n".join(output_list)

    def english_stopwords(self):
        return stopwords.words("english")

    def remove_stopwords(self, input_str, stopwords):
        word_list = re.findall(r'\S+|\n', input_str)
        stopwords = set(stopwords)
        word_list = [w for w in word_list if w not in stopwords]
        output_str = " ".join(word_list)
        output_str = re.sub(r" \n ", "\n", output_str)
        return output_str

    def prepare_data(self):
        output = []
        for el in self.premature_list:
            el = self.single_newlines(el)
            el = self.apply_line_by_line(el, self.remove_unnecessary_characters)
            el = self.multiple_blanks_to_one(el)
            el = self.format_numbers(el)
            if self.remove_stopwords_flag:
                el = self.remove_stopwords(el, self.english_stopwords())
            output.append(el)
        self.data = output
        return output
