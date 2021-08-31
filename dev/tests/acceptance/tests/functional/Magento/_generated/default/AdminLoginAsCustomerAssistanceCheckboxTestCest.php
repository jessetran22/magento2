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
 * @Title("[NO TESTCASEID]: Login as Customer assistance checkbox test")
 * @Description("Verify that 'Allow remote shopping assistance' checkbox is present on Edit Account Information page<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerAssistanceCheckboxTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerAssistanceCheckboxTestCest
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
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->createEntity("createFirstCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createFirstCustomer
		$I->createEntity("createSecondCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createSecondCustomer
		$I->comment("Entering Action Group [loginAsDefaultUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultUser
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultUser
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultUser
		$I->comment("Exiting Action Group [loginAsDefaultUser] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->deleteEntity("createSecondCustomer", "hook"); // stepKey: deleteSecondCustomer
		$I->comment("Entering Action Group [logoutAfter] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAfter
		$I->comment("Exiting Action Group [logoutAfter] AdminLogoutActionGroup");
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"Opt in/out"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerAssistanceCheckboxTest(AcceptanceTester $I)
	{
		$I->comment("Login into First Customer account");
		$I->comment("Entering Action Group [loginAsFirstCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsFirstCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsFirstCustomer
		$I->fillField("#email", $I->retrieveEntityField('createFirstCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsFirstCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createFirstCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsFirstCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsFirstCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsFirstCustomer
		$I->comment("Exiting Action Group [loginAsFirstCustomer] LoginToStorefrontActionGroup");
		$I->comment("Open My Account > Order by SKU");
		$I->comment("Entering Action Group [goToFirstMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageGoToFirstMyAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToFirstMyAccountPage
		$I->comment("Exiting Action Group [goToFirstMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [openFirstAccountInformation] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Account Information']"); // stepKey: goToAddressBookOpenFirstAccountInformation
		$I->waitForPageLoad(60); // stepKey: goToAddressBookOpenFirstAccountInformationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenFirstAccountInformation
		$I->comment("Exiting Action Group [openFirstAccountInformation] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Assert Assistance checkbox is present and checked");
		$I->comment("Entering Action Group [assertAssistanceAllowedCheckboxChecked] StorefrontAssertLoginAssistanceAllowedCheckboxCheckedActionGroup");
		$I->waitForElement(".form-edit-account input[name='assistance_allowed_checkbox']", 30); // stepKey: waitForAllowAssistanceCheckboxAssertAssistanceAllowedCheckboxChecked
		$I->seeCheckboxIsChecked(".form-edit-account input[name='assistance_allowed_checkbox']"); // stepKey: assertAllowAssistanceCheckboxCheckedAssertAssistanceAllowedCheckboxChecked
		$I->comment("Exiting Action Group [assertAssistanceAllowedCheckboxChecked] StorefrontAssertLoginAssistanceAllowedCheckboxCheckedActionGroup");
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [logoutFirstCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutFirstCustomer
		$I->comment("Exiting Action Group [logoutFirstCustomer] StorefrontCustomerLogoutActionGroup");
		$I->comment("Login into Second Customer account");
		$I->comment("Entering Action Group [loginAsSecondCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsSecondCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsSecondCustomer
		$I->fillField("#email", $I->retrieveEntityField('createSecondCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsSecondCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createSecondCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsSecondCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsSecondCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsSecondCustomer
		$I->comment("Exiting Action Group [loginAsSecondCustomer] LoginToStorefrontActionGroup");
		$I->comment("Open My Account > Order by SKU");
		$I->comment("Entering Action Group [goToSecondMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageGoToSecondMyAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToSecondMyAccountPage
		$I->comment("Exiting Action Group [goToSecondMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [openSecondAccountInformation] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Account Information']"); // stepKey: goToAddressBookOpenSecondAccountInformation
		$I->waitForPageLoad(60); // stepKey: goToAddressBookOpenSecondAccountInformationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenSecondAccountInformation
		$I->comment("Exiting Action Group [openSecondAccountInformation] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Assert Assistance checkbox is present and unchecked");
		$I->comment("Entering Action Group [assertAssistanceAllowedCheckboxUnchecked] StorefrontAssertLoginAssistanceAllowedCheckboxUncheckedActionGroup");
		$I->waitForElement(".form-edit-account input[name='assistance_allowed_checkbox']", 30); // stepKey: waitForAllowAssistanceCheckboxAssertAssistanceAllowedCheckboxUnchecked
		$I->dontSeeCheckboxIsChecked(".form-edit-account input[name='assistance_allowed_checkbox']"); // stepKey: assertAllowAssistanceCheckboxUncheckedAssertAssistanceAllowedCheckboxUnchecked
		$I->comment("Exiting Action Group [assertAssistanceAllowedCheckboxUnchecked] StorefrontAssertLoginAssistanceAllowedCheckboxUncheckedActionGroup");
	}
}
