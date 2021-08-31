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
 * @Title("MC-10800: Checking welcome message for persistent customer after logout")
 * @Description("Checking welcome message for persistent customer after logout<h3>Test files</h3>app/code/Magento/Persistent/Test/Mftf/Test/StorefrontCorrectWelcomeMessageAfterCustomerIsLoggedOutTest.xml<br>")
 * @TestCaseId("MC-10800")
 * @group persistent
 * @group customer
 */
class StorefrontCorrectWelcomeMessageAfterCustomerIsLoggedOutTestCest
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Enable Persistence");
		$I->createEntity("enablePersistent", "hook", "PersistentConfigEnabled", [], []); // stepKey: enablePersistent
		$I->createEntity("persistentLogoutClearDisable", "hook", "PersistentLogoutClearDisable", [], []); // stepKey: persistentLogoutClearDisable
		$I->comment("Create customers");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$createCustomerForPersistentFields['firstname'] = "John1";
		$createCustomerForPersistentFields['lastname'] = "Doe1";
		$I->createEntity("createCustomerForPersistent", "hook", "Simple_US_Customer", [], $createCustomerForPersistentFields); // stepKey: createCustomerForPersistent
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Roll back configuration");
		$I->createEntity("setDefaultPersistentState", "hook", "PersistentConfigDefault", [], []); // stepKey: setDefaultPersistentState
		$I->createEntity("persistentLogoutClearEnabled", "hook", "PersistentLogoutClearEnabled", [], []); // stepKey: persistentLogoutClearEnabled
		$I->comment("Logout customer on Storefront");
		$I->comment("Entering Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront
		$I->comment("Exiting Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete customers");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCustomerForPersistent", "hook"); // stepKey: deleteCustomerForPersistent
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
	 * @Features({"Persistent"})
	 * @Stories({"MAGETWO-97278 - Incorrect use of cookies for customer"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCorrectWelcomeMessageAfterCustomerIsLoggedOutTest(AcceptanceTester $I)
	{
		$I->comment("Login as a Customer with remember me unchecked");
		$I->comment("Entering Action Group [loginToStorefrontAccountWithRememberMeUnchecked] CustomerLoginOnStorefrontWithRememberMeUnCheckedActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccountWithRememberMeUnchecked
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccountWithRememberMeUnchecked
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccountWithRememberMeUnchecked
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccountWithRememberMeUnchecked
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccountWithRememberMeUnchecked
		$I->uncheckOption("[name='persistent_remember_me']"); // stepKey: unCheckRememberMeLoginToStorefrontAccountWithRememberMeUnchecked
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWithRememberMeUnchecked
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWithRememberMeUncheckedWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccountWithRememberMeUnchecked
		$I->comment("Exiting Action Group [loginToStorefrontAccountWithRememberMeUnchecked] CustomerLoginOnStorefrontWithRememberMeUnCheckedActionGroup");
		$I->comment("Check customer name and last name in welcome message");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: seeCustomerAccountPageUrl
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . "!", ".greet.welcome"); // stepKey: seeLoggedInCustomerWelcomeMessage
		$I->comment("Logout and check default welcome message");
		$I->comment("Entering Action Group [storefrontCustomerLogout] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->conditionalClick(".panel.header .customer-welcome .customer-name", ".panel.header .customer-welcome .customer-menu .authorization-link a", false); // stepKey: clickHeaderCustomerMenuButtonStorefrontCustomerLogout
		$I->waitForPageLoad(30); // stepKey: clickHeaderCustomerMenuButtonStorefrontCustomerLogoutWaitForPageLoad
		$I->click(".panel.header .customer-welcome .customer-menu .authorization-link a"); // stepKey: clickSignOutButtonStorefrontCustomerLogout
		$I->waitForPageLoad(30); // stepKey: clickSignOutButtonStorefrontCustomerLogoutWaitForPageLoad
		$I->comment("Exiting Action Group [storefrontCustomerLogout] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->comment("Entering Action Group [seeCustomerSignOutPageUrl] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->seeInCurrentUrl("customer/account/logoutSuccess/"); // stepKey: seeOnSignInPageSeeCustomerSignOutPageUrl
		$I->comment("Exiting Action Group [seeCustomerSignOutPageUrl] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->see("Default welcome msg!", ".greet.welcome"); // stepKey: seeDefaultWelcomeMessage
		$I->comment("Login as a Customer with remember me checked");
		$I->comment("Entering Action Group [loginToStorefrontAccountWithRememberMeChecked] CustomerLoginOnStorefrontWithRememberMeCheckedActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccountWithRememberMeChecked
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccountWithRememberMeChecked
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccountWithRememberMeChecked
		$I->fillField("#email", $I->retrieveEntityField('createCustomerForPersistent', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccountWithRememberMeChecked
		$I->fillField("#pass", $I->retrieveEntityField('createCustomerForPersistent', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccountWithRememberMeChecked
		$I->checkOption("[name='persistent_remember_me']"); // stepKey: checkRememberMeLoginToStorefrontAccountWithRememberMeChecked
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWithRememberMeChecked
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWithRememberMeCheckedWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccountWithRememberMeChecked
		$I->comment("Exiting Action Group [loginToStorefrontAccountWithRememberMeChecked] CustomerLoginOnStorefrontWithRememberMeCheckedActionGroup");
		$I->comment("Check customer name and last name in welcome message");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: seeCustomerAccountPageUrl1
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomerForPersistent', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomerForPersistent', 'lastname', 'test') . "!", ".greet.welcome"); // stepKey: seeLoggedInCustomerWelcomeMessage1
		$I->comment("Logout and check persistent customer welcome message");
		$I->comment("Entering Action Group [storefrontCustomerLogout1] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->conditionalClick(".panel.header .customer-welcome .customer-name", ".panel.header .customer-welcome .customer-menu .authorization-link a", false); // stepKey: clickHeaderCustomerMenuButtonStorefrontCustomerLogout1
		$I->waitForPageLoad(30); // stepKey: clickHeaderCustomerMenuButtonStorefrontCustomerLogout1WaitForPageLoad
		$I->click(".panel.header .customer-welcome .customer-menu .authorization-link a"); // stepKey: clickSignOutButtonStorefrontCustomerLogout1
		$I->waitForPageLoad(30); // stepKey: clickSignOutButtonStorefrontCustomerLogout1WaitForPageLoad
		$I->comment("Exiting Action Group [storefrontCustomerLogout1] CustomerLogoutStorefrontByMenuItemsActionGroup");
		$I->comment("Entering Action Group [seeCustomerSignOutPageUrl1] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->seeInCurrentUrl("customer/account/logoutSuccess/"); // stepKey: seeOnSignInPageSeeCustomerSignOutPageUrl1
		$I->comment("Exiting Action Group [seeCustomerSignOutPageUrl1] AssertStorefrontCustomerLogoutSuccessPageActionGroup");
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomerForPersistent', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomerForPersistent', 'lastname', 'test') . "! Not you?", ".greet.welcome"); // stepKey: seePersistentWelcomeMessage
		$I->dontSee("Not you? Not you?", ".greet.welcome"); // stepKey: verifyNotYouLinkNotDuplicated
	}
}
