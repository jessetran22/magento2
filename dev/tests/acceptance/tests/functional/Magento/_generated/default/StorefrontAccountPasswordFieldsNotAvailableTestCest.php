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
 * @Title("MC-14369: Password Fields not Available")
 * @Description("User Cannot Change Password Until Checkbox Change Password Unchecked<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/StorefrontAccountPasswordFieldsNotAvailableTest.xml<br>")
 * @TestCaseId("MC-14369")
 * @group security
 * @group mtf_migrated
 */
class StorefrontAccountPasswordFieldsNotAvailableTestCest
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Security"})
	 * @Stories({"Password Fields not Available on Frontend Until Checkbox Change Password Unchecked"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAccountPasswordFieldsNotAvailableTest(AcceptanceTester $I)
	{
		$I->comment("TEST BODY");
		$I->comment("Go to storefront home page");
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Login as created customer");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Navigate to \"Change Account Information\" tab");
		$I->comment("Entering Action Group [goToCustomerEditPage] StorefrontNavigateToAccountInformationChangeActionGroup");
		$I->amOnPage("/customer/account/edit/"); // stepKey: goToCustomerEditPageGoToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForEditPageGoToCustomerEditPage
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabGoToCustomerEditPage
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabGoToCustomerEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedGoToCustomerEditPage
		$I->comment("Exiting Action Group [goToCustomerEditPage] StorefrontNavigateToAccountInformationChangeActionGroup");
		$I->comment("Assert Account Password Fields not Available");
		$I->comment("Entering Action Group [uncheckedCheckbox] AssertStorefrontAccountPasswordFieldsNotAvailableActionGroup");
		$I->dontSee("#current-password"); // stepKey: dontSeeCurrentPasswordFieldUncheckedCheckbox
		$I->dontSee("#password"); // stepKey: dontSeeNewPasswordFieldUncheckedCheckbox
		$I->dontSee("#password-confirmation"); // stepKey: dontSeeConfirmPasswordFieldUncheckedCheckbox
		$I->comment("Exiting Action Group [uncheckedCheckbox] AssertStorefrontAccountPasswordFieldsNotAvailableActionGroup");
		$I->comment("END TEST BODY");
	}
}
