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
 * @Title("MC-14368: Notify the customer if password complexity does not match the requirements")
 * @Description("Notify the customer if password complexity does not match the requirements<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/NewCustomerPasswordComplexityTest.xml<br>")
 * @TestCaseId("MC-14368")
 * @group security
 * @group mtf_migrated
 */
class NewCustomerPasswordComplexityTestCest
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
	 * @Stories({"Checking customer's password complexity"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NewCustomerPasswordComplexityTest(AcceptanceTester $I)
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
		$I->comment("Fill Registration Form with not secure enough password");
		$I->comment("Entering Action Group [fillRegistrationFormPasswordNotSecure] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillRegistrationFormPasswordNotSecure
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillRegistrationFormPasswordNotSecure
		$I->fillField("#email_address", msq("Simple_Customer_With_Not_Secure_Password") . "John.Doe@example.com"); // stepKey: fillEmailFillRegistrationFormPasswordNotSecure
		$I->fillField("#password", "123123qa"); // stepKey: fillPasswordFillRegistrationFormPasswordNotSecure
		$I->fillField("#password-confirmation", "123123qa"); // stepKey: fillConfirmPasswordFillRegistrationFormPasswordNotSecure
		$I->comment("Exiting Action Group [fillRegistrationFormPasswordNotSecure] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("See the Error");
		$I->comment("Entering Action Group [seeTheErrorPasswordSecure] AssertMessageCustomerCreateAccountPasswordComplexityActionGroup");
		$I->see("Minimum of different classes of characters in password is 3. Classes of characters: Lower Case, Upper Case, Digits, Special Characters.", "#password-error"); // stepKey: verifyMessageSeeTheErrorPasswordSecure
		$I->comment("Exiting Action Group [seeTheErrorPasswordSecure] AssertMessageCustomerCreateAccountPasswordComplexityActionGroup");
	}
}
