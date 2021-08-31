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
 * @Title("MC-5301: Create retail customer group")
 * @Description("Create retail customer group<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCreateRetailCustomerGroupTest.xml<br>")
 * @TestCaseId("MC-5301")
 * @group customer
 * @group mtf_migrated
 */
class AdminCreateRetailCustomerGroupTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "Group-" . msq("CustomCustomerGroup")); // stepKey: fillNameFieldOnFiltersSectionDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='Group-" . msq("CustomCustomerGroup") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickSelectButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='Group-" . msq("CustomCustomerGroup") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickOnDeleteItemDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteItemDeleteCustomerGroupWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm div.modal-content", 30); // stepKey: waitForConfirmModalDeleteCustomerGroup
		$I->see("Are you sure you want to delete a Group-" . msq("CustomCustomerGroup") . " record?", ".modal-popup.confirm div.modal-content"); // stepKey: seeRemoveMessageDeleteCustomerGroup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroup
		$I->waitForPageLoad(60); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroupWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomerGroup
		$I->comment("Exiting Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Customer"})
	 * @Stories({"Create customer group"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateRetailCustomerGroupTest(AcceptanceTester $I)
	{
		$I->comment("Steps: 1. Log in to backend as admin user.
                    2. Navigate to Stores > Other Settings > Customer Groups.
                    3. Start to create new Customer Group.
                    4. Fill in all data according to data set.   Tax Class  -  \"Retail customer\"
                    5. Click \"Save Customer Group\" button.");
		$I->comment("Assert \"You saved the customer group.\" success message displayed");
		$I->comment("Assert created Customer Group displayed In Grid");
		$I->comment("Entering Action Group [createCustomerGroup] AdminCreateCustomerGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/new/"); // stepKey: goToNewCustomerGroupPageCreateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForNewCustomerGroupPageLoadCreateCustomerGroup
		$I->comment("Set tax class for customer group");
		$I->fillField("#customer_group_code", "Group-" . msq("CustomCustomerGroup")); // stepKey: fillGroupNameCreateCustomerGroup
		$I->selectOption("#tax_class_id", "Retail Customer"); // stepKey: selectTaxClassOptionCreateCustomerGroup
		$I->click("#save"); // stepKey: clickToSaveCustomerGroupCreateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupSavedCreateCustomerGroup
		$I->see("You saved the customer group."); // stepKey: seeCustomerGroupSaveMessageCreateCustomerGroup
		$I->comment("Exiting Action Group [createCustomerGroup] AdminCreateCustomerGroupActionGroup");
		$I->comment("Entering Action Group [assertCustomerGroupDisplayedInGrid] AdminAssertCustomerGroupPresentInGrid");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageAssertCustomerGroupDisplayedInGrid
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageAssertCustomerGroupDisplayedInGridWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetAssertCustomerGroupDisplayedInGrid
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetAssertCustomerGroupDisplayedInGridWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "Group-" . msq("CustomCustomerGroup")); // stepKey: fillNameFieldOnFiltersSectionAssertCustomerGroupDisplayedInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonAssertCustomerGroupDisplayedInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonAssertCustomerGroupDisplayedInGridWaitForPageLoad
		$I->see("Group-" . msq("CustomCustomerGroup"), "//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Group')]/preceding-sibling::th) +1 ]"); // stepKey: seeCustomerGroupNameInGridAssertCustomerGroupDisplayedInGrid
		$I->comment("- Assume we are on admin customer group page.");
		$I->comment("Exiting Action Group [assertCustomerGroupDisplayedInGrid] AdminAssertCustomerGroupPresentInGrid");
		$I->comment("6. Go to Catalog -> Products  -> click  \"Add Product\" button -> click \"Advanced Pricing\" link -> Customer Group Price -> click  \"Add\" button");
		$I->comment("Assert: Customer Group Displayed On Product Form");
		$I->comment("Entering Action Group [assertCustomerGroupDisplayedOnProductForm] AdminAssertCustomerGroupOnProductForm");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: amOnProductCreatePageAssertCustomerGroupDisplayedOnProductForm
		$I->waitForElementVisible("button[data-index='advanced_pricing_button']", 30); // stepKey: waitForAdvancedPricingLinkVisibleAssertCustomerGroupDisplayedOnProductForm
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingLinkVisibleAssertCustomerGroupDisplayedOnProductFormWaitForPageLoad
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonAssertCustomerGroupDisplayedOnProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonAssertCustomerGroupDisplayedOnProductFormWaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForAddButtonVisibleAssertCustomerGroupDisplayedOnProductForm
		$I->waitForPageLoad(30); // stepKey: waitForAddButtonVisibleAssertCustomerGroupDisplayedOnProductFormWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: clickAddButtonAssertCustomerGroupDisplayedOnProductForm
		$I->waitForPageLoad(30); // stepKey: clickAddButtonAssertCustomerGroupDisplayedOnProductFormWaitForPageLoad
		$I->see("Group-" . msq("CustomCustomerGroup"), "[name='product[tier_price][0][cust_group]']"); // stepKey: assertCustomerGroupPresentAssertCustomerGroupDisplayedOnProductForm
		$I->comment("Exiting Action Group [assertCustomerGroupDisplayedOnProductForm] AdminAssertCustomerGroupOnProductForm");
		$I->comment("7. Go to Customers -> All Customers  -> click  \"Add New Customer\" button");
		$I->comment("Assert   created  Customer Group  displayed On Customer Form");
		$I->comment("Entering Action Group [assertCustomerGroupDisplayedOnCustomerForm] AdminAssertCustomerGroupOnCustomerForm");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/new"); // stepKey: amOnCustomerCreatePageAssertCustomerGroupDisplayedOnCustomerForm
		$I->waitForElementVisible("[name='customer[group_id]']", 30); // stepKey: waitForElementVisibleAssertCustomerGroupDisplayedOnCustomerForm
		$I->see("Group-" . msq("CustomCustomerGroup"), "[name='customer[group_id]']"); // stepKey: assertCustomerGroupPresentAssertCustomerGroupDisplayedOnCustomerForm
		$I->comment("Exiting Action Group [assertCustomerGroupDisplayedOnCustomerForm] AdminAssertCustomerGroupOnCustomerForm");
		$I->comment("8. Go to Marketing - Catalog Price Rule - click  \"Add New Rule\" button");
		$I->comment("Assert   created  Customer Group  displayed On Catalog Price Rule Form");
		$I->comment("Entering Action Group [assertCustomerGroupDisplayedOnCatalogPriceRuleForm] AdminAssertCustomerGroupOnCatalogPriceRuleForm");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: amOnCatalogPriceRuleCreatePageAssertCustomerGroupDisplayedOnCatalogPriceRuleForm
		$I->waitForElementVisible("[name='customer_group_ids']", 30); // stepKey: waitForElementVisibleAssertCustomerGroupDisplayedOnCatalogPriceRuleForm
		$I->see("Group-" . msq("CustomCustomerGroup"), "[name='customer_group_ids']"); // stepKey: assertCustomerGroupPresentOnCatalogPriceRuleFormAssertCustomerGroupDisplayedOnCatalogPriceRuleForm
		$I->comment("Exiting Action Group [assertCustomerGroupDisplayedOnCatalogPriceRuleForm] AdminAssertCustomerGroupOnCatalogPriceRuleForm");
		$I->comment("9. Go to Marketing - Cart Price Rule - click  \"Add New Rule\" button");
		$I->comment("Assert   created  Customer Group  displayed On Cart Price Rule Form");
		$I->comment("Entering Action Group [assertCustomerGroupDisplayedOnCartPriceRuleForm] AdminAssertCustomerGroupOnCartPriceRuleForm");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/new/"); // stepKey: amOnCartPriceRuleCreateCreatePageAssertCustomerGroupDisplayedOnCartPriceRuleForm
		$I->waitForElementVisible("select[name='customer_group_ids']", 30); // stepKey: waitForElementVisibleAssertCustomerGroupDisplayedOnCartPriceRuleForm
		$I->see("Group-" . msq("CustomCustomerGroup"), "select[name='customer_group_ids']"); // stepKey: assertCustomerGroupPresentOnCartPriceRuleFormAssertCustomerGroupDisplayedOnCartPriceRuleForm
		$I->comment("Exiting Action Group [assertCustomerGroupDisplayedOnCartPriceRuleForm] AdminAssertCustomerGroupOnCartPriceRuleForm");
	}
}
