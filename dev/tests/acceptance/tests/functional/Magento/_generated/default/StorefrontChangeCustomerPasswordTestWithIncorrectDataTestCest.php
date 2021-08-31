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
 * @Title("MC-14371: Changing Customer Password Test with Incorrect Data")
 * @Description("Changing Customer's password using Incorrect Current Password<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/StorefrontChangeCustomerPasswordTestWithIncorrectDataTest.xml<br>")
 * @TestCaseId("MC-14371")
 * @group security
 * @group mtf_migrated
 */
class StorefrontChangeCustomerPasswordTestWithIncorrectDataTestCest
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
	 * @Stories({"Changing Customer's Password With Incorrect Current Password"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontChangeCustomerPasswordTestWithIncorrectDataTest(AcceptanceTester $I)
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
		$I->comment("Change Password with InCorrect Current Password");
		$I->comment("Entering Action Group [changePasswordWithInCorrectData] StorefrontCustomerChangePasswordActionGroup");
		$I->checkOption(".form-edit-account input[name='change_password']"); // stepKey: clickChangePasswordlCheckboxChangePasswordWithInCorrectData
		$I->fillField("#current-password", "123123^q"); // stepKey: fillCurrentPasswordChangePasswordWithInCorrectData
		$I->fillField("#password", "123123^q"); // stepKey: fillNewPasswordChangePasswordWithInCorrectData
		$I->fillField("#password-confirmation", "123123^q"); // stepKey: confirmNewPasswordChangePasswordWithInCorrectData
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangePasswordWithInCorrectData
		$I->waitForPageLoad(30); // stepKey: saveChangeChangePasswordWithInCorrectDataWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangePasswordWithInCorrectData
		$I->comment("Exiting Action Group [changePasswordWithInCorrectData] StorefrontCustomerChangePasswordActionGroup");
		$I->comment("See Error Message");
		$I->comment("Entering Action Group [assertAccountMessageFirstAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("The password doesn't match this account. Verify the password and try again.", "#maincontent .message-error"); // stepKey: verifyMessageAssertAccountMessageFirstAttempt
		$I->comment("Exiting Action Group [assertAccountMessageFirstAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("END TEST BODY");
	}
}
