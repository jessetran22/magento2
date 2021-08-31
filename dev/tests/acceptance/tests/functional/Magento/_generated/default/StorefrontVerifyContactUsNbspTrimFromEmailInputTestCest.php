<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-42234: Test for contact form to trim non-breaking spaces at the end of the email address")
 * @Description("Non-break spaces should be trimmed from the contact form email address input field<h3>Test files</h3>app/code/Magento/Contact/Test/Mftf/Test/StorefrontVerifyContactUsNbspTrimFromEmailInputTest.xml<br>")
 * @TestCaseId("MC-42234")
 * @group contact
 */
class StorefrontVerifyContactUsNbspTrimFromEmailInputTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	 * @Features({"Contact"})
	 * @Stories({"Submit Contact Us Form"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyContactUsNbspTrimFromEmailInputTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToContactUsPage] StorefrontOpenContactUsPageActionGroup");
		$I->amOnPage("/contact/"); // stepKey: amOnContactUpPageGoToContactUsPage
		$I->waitForPageLoad(30); // stepKey: waitForContactUpPageLoadGoToContactUsPage
		$I->comment("Exiting Action Group [goToContactUsPage] StorefrontOpenContactUsPageActionGroup");
		$I->comment("Entering Action Group [fillUpTheFormWithCustomerDataWithNbsp] StorefrontFillContactUsFormActionGroup");
		$I->fillField("#contact-form input[name='name']", "John"); // stepKey: fillNameFillUpTheFormWithCustomerDataWithNbsp
		$I->fillField("#contact-form input[name='email']", msq("Simple_US_Customer_Nbsp_In_Email") . "John.Doe@example.com  "); // stepKey: fillEmailFillUpTheFormWithCustomerDataWithNbsp
		$I->fillField("#contact-form textarea[name='comment']", "Lorem ipsum dolor sit amet, ne enim aliquando eam, oblique deserunt no usu. Unique: " . msq("DefaultContactUsData")); // stepKey: fillCommentFillUpTheFormWithCustomerDataWithNbsp
		$I->comment("Exiting Action Group [fillUpTheFormWithCustomerDataWithNbsp] StorefrontFillContactUsFormActionGroup");
		$I->comment("Entering Action Group [assertEmailWasTrimmedInTheInput] StorefrontAssertEmailAddressTrimmedActionGroup");
		$trimEmailAssertEmailWasTrimmedInTheInput = $I->executeJS("return '" . msq("Simple_US_Customer_Nbsp_In_Email") . "John.Doe@example.com  '.trim();"); // stepKey: trimEmailAssertEmailWasTrimmedInTheInput
		$grabEmailFromInputAssertEmailWasTrimmedInTheInput = $I->grabValueFrom("#contact-form input[name='email']"); // stepKey: grabEmailFromInputAssertEmailWasTrimmedInTheInput
		$I->assertEquals("$trimEmailAssertEmailWasTrimmedInTheInput", "$grabEmailFromInputAssertEmailWasTrimmedInTheInput"); // stepKey: assertEmailsAreEqualAssertEmailWasTrimmedInTheInput
		$I->comment("Exiting Action Group [assertEmailWasTrimmedInTheInput] StorefrontAssertEmailAddressTrimmedActionGroup");
		$I->comment("Entering Action Group [submitContactUsForm] StorefrontSubmitContactUsFormActionGroup");
		$I->click("#contact-form button[type='submit']"); // stepKey: clickSubmitFormButtonSubmitContactUsForm
		$I->waitForPageLoad(30); // stepKey: clickSubmitFormButtonSubmitContactUsFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCommentSubmittedSubmitContactUsForm
		$I->comment("Exiting Action Group [submitContactUsForm] StorefrontSubmitContactUsFormActionGroup");
		$I->comment("Entering Action Group [assertContactUsFormSuccessfullySubmitted] AssertMessageContactUsFormActionGroup");
		$I->see("Thanks for contacting us with your comments and questions. We'll respond to you very soon.", "#maincontent .message-success"); // stepKey: verifyMessageAssertContactUsFormSuccessfullySubmitted
		$I->comment("Exiting Action Group [assertContactUsFormSuccessfullySubmitted] AssertMessageContactUsFormActionGroup");
	}
}
