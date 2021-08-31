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
 * @Title("MC-14367: Notify the customer if password length does not match the requirements")
 * @Description("Notify the customer if password length does not match the requirements<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/NewCustomerPasswordLengthTest.xml<br>")
 * @TestCaseId("MC-14367")
 * @group security
 * @group mtf_migrated
 */
class NewCustomerPasswordLengthTestCest
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
    }
	/**
	 * @Features({"Security"})
	 * @Stories({"Checking customer's password length"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NewCustomerPasswordLengthTest(AcceptanceTester $I)
	{
		$I->comment("Go to storefront home page");
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("See the Registration Link");
		$I->comment("Entering Action Group [seeTheLink] StorefrontSeeHeaderLinksActionGroup");
		$I->see("Create an Account", "ul.header.links"); // stepKey: seeElementSeeTheLink
		$I->comment("Exiting Action Group [seeTheLink] StorefrontSeeHeaderLinksActionGroup");
		$I->comment("Click the Registration Link");
		$I->comment("Entering Action Group [clickTheLink] StorefrontClickHeaderLinkActionGroup");
		$I->click("//ul[contains(@class, 'header') and contains(@class, 'links')]/li/a[contains(text(),'Create an Account')]"); // stepKey: clickTheLinkClickTheLink
		$I->waitForPageLoad(30); // stepKey: waitClickTheLink
		$I->comment("Exiting Action Group [clickTheLink] StorefrontClickHeaderLinkActionGroup");
		$I->comment("Fill Registration Form with Password length is bellow 8 Characters");
		$I->comment("Entering Action Group [fillRegistrationFormPasswordLengthBellowEightCharacters] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillRegistrationFormPasswordLengthBellowEightCharacters
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillRegistrationFormPasswordLengthBellowEightCharacters
		$I->fillField("#email_address", msq("Simple_Customer_With_Password_Length_Is_Below_Eight_Characters") . "John.Doe@example.com"); // stepKey: fillEmailFillRegistrationFormPasswordLengthBellowEightCharacters
		$I->fillField("#password", "123123"); // stepKey: fillPasswordFillRegistrationFormPasswordLengthBellowEightCharacters
		$I->fillField("#password-confirmation", "123123"); // stepKey: fillConfirmPasswordFillRegistrationFormPasswordLengthBellowEightCharacters
		$I->comment("Exiting Action Group [fillRegistrationFormPasswordLengthBellowEightCharacters] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("See the Error");
		$I->comment("Entering Action Group [seeTheErrorPasswordLength] AssertMessageCustomerCreateAccountPasswordComplexityActionGroup");
		$I->see("Minimum length of this field must be equal or greater than 8 symbols. Leading and trailing spaces will be ignored.", "#password-error"); // stepKey: verifyMessageSeeTheErrorPasswordLength
		$I->comment("Exiting Action Group [seeTheErrorPasswordLength] AssertMessageCustomerCreateAccountPasswordComplexityActionGroup");
	}
}
