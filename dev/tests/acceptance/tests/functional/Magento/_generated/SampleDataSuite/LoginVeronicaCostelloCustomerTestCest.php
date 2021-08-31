<?php
namespace Magento\AcceptanceTest\_SampleDataSuite\Backend;

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
 * @Title("MC-11834: Should be able to login as a Veronica Costello customer.")
 * @Description("Should be able to login as a Veronica Costello customer and navigate through customer menu.<h3>Test files</h3>Users/jessetran/Documents/magento2-sample-data/app/code/Magento/CustomerSampleData/Test/Mftf/Test/LoginVeronicaCostelloCustomerTest.xml<br>")
 * @TestCaseId("MC-11834")
 * @group sampleData
 */
class LoginVeronicaCostelloCustomerTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] StorefrontSignOutActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonLogout
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutLogout
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLogout
		$I->see("You are signed out"); // stepKey: signOutLogout
		$I->comment("Exiting Action Group [logout] StorefrontSignOutActionGroup");
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
	 * @Features({"CustomerSampleData"})
	 * @Stories({"Sample data"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function LoginVeronicaCostelloCustomerTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", "roni_cost@example.com"); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", "roni_cost3@example.com"); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openCustomersMyAccountPage] OpenMyAccountPageActionGroup");
		$I->click(".customer-name"); // stepKey: openCustomerDropdownMenuOpenCustomersMyAccountPage
		$I->click("//*[contains(@class, 'page-header')]//*[contains(@class, 'customer-menu')]//a[contains(., 'My Account')]"); // stepKey: clickOnMyAccountOpenCustomersMyAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomersMyAccountPage
		$I->comment("Exiting Action Group [openCustomersMyAccountPage] OpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [openAccountInformationTab] NavigateThroughCustomerTabsActionGroup");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Account Information']"); // stepKey: clickOnDesiredNavItemOpenAccountInformationTab
		$I->waitForPageLoad(60); // stepKey: clickOnDesiredNavItemOpenAccountInformationTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAccountInformationTab
		$I->comment("Exiting Action Group [openAccountInformationTab] NavigateThroughCustomerTabsActionGroup");
		$I->comment("Entering Action Group [assertAccountInformationPageTitle] AssertCustomerAccountPageTitleActionGroup");
		$I->see("Account Information", "#maincontent .column.main [data-ui-id='page-title-wrapper']"); // stepKey: assertPageTitleAssertAccountInformationPageTitle
		$I->comment("Exiting Action Group [assertAccountInformationPageTitle] AssertCustomerAccountPageTitleActionGroup");
		$I->comment("Entering Action Group [openAddressBookTab] NavigateThroughCustomerTabsActionGroup");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Address Book']"); // stepKey: clickOnDesiredNavItemOpenAddressBookTab
		$I->waitForPageLoad(60); // stepKey: clickOnDesiredNavItemOpenAddressBookTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAddressBookTab
		$I->comment("Exiting Action Group [openAddressBookTab] NavigateThroughCustomerTabsActionGroup");
		$I->comment("Entering Action Group [assertAddressBookPageTitle] AssertCustomerAccountPageTitleActionGroup");
		$I->see("Address Book", "#maincontent .column.main [data-ui-id='page-title-wrapper']"); // stepKey: assertPageTitleAssertAddressBookPageTitle
		$I->comment("Exiting Action Group [assertAddressBookPageTitle] AssertCustomerAccountPageTitleActionGroup");
		$I->comment("Entering Action Group [openMyOrdersTab] NavigateThroughCustomerTabsActionGroup");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: clickOnDesiredNavItemOpenMyOrdersTab
		$I->waitForPageLoad(60); // stepKey: clickOnDesiredNavItemOpenMyOrdersTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMyOrdersTab
		$I->comment("Exiting Action Group [openMyOrdersTab] NavigateThroughCustomerTabsActionGroup");
		$I->comment("Entering Action Group [assertMyOrdersPageTitle] AssertCustomerAccountPageTitleActionGroup");
		$I->see("My Orders", "#maincontent .column.main [data-ui-id='page-title-wrapper']"); // stepKey: assertPageTitleAssertMyOrdersPageTitle
		$I->comment("Exiting Action Group [assertMyOrdersPageTitle] AssertCustomerAccountPageTitleActionGroup");
		$I->comment("Entering Action Group [openMyWishListTab] NavigateThroughCustomerTabsActionGroup");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Wish List']"); // stepKey: clickOnDesiredNavItemOpenMyWishListTab
		$I->waitForPageLoad(60); // stepKey: clickOnDesiredNavItemOpenMyWishListTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMyWishListTab
		$I->comment("Exiting Action Group [openMyWishListTab] NavigateThroughCustomerTabsActionGroup");
		$I->comment("Entering Action Group [assertMyWishListPageTitle] AssertCustomerAccountPageTitleActionGroup");
		$I->see("My Wish List", "#maincontent .column.main [data-ui-id='page-title-wrapper']"); // stepKey: assertPageTitleAssertMyWishListPageTitle
		$I->comment("Exiting Action Group [assertMyWishListPageTitle] AssertCustomerAccountPageTitleActionGroup");
	}
}
