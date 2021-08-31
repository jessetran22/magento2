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
 * @Title("MC-14590: Delete Customer Group in Admin Panel")
 * @Description("Admin should be able to delete a Customer Group<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/DeleteCustomerGroupTest.xml<br>app/code/Magento/CatalogRule/Test/Mftf/Test/DeleteCustomerGroupTest.xml<br>app/code/Magento/SalesRule/Test/Mftf/Test/DeleteCustomerGroupTest.xml<br>")
 * @TestCaseId("MC-14590")
 * @group customers
 * @group mtf_migrated
 */
class DeleteCustomerGroupTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customerGroup", "hook", "CustomCustomerGroup", [], []); // stepKey: customerGroup
		$I->createEntity("customer", "hook", "UsCustomerAssignedToNewCustomerGroup", ["customerGroup"], []); // stepKey: customer
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
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Delete Customer Group"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteCustomerGroupTest(AcceptanceTester $I)
	{
		$I->comment("Customer Group success delete message");
		$I->comment("Entering Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", $I->retrieveEntityField('customerGroup', 'code', 'test')); // stepKey: fillNameFieldOnFiltersSectionDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='" . $I->retrieveEntityField('customerGroup', 'code', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickSelectButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='" . $I->retrieveEntityField('customerGroup', 'code', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickOnDeleteItemDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteItemDeleteCustomerGroupWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm div.modal-content", 30); // stepKey: waitForConfirmModalDeleteCustomerGroup
		$I->see("Are you sure you want to delete a " . $I->retrieveEntityField('customerGroup', 'code', 'test') . " record?", ".modal-popup.confirm div.modal-content"); // stepKey: seeRemoveMessageDeleteCustomerGroup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroup
		$I->waitForPageLoad(60); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroupWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomerGroup
		$I->comment("Exiting Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->comment("Entering Action Group [assertCustomerGroupNotInGrid] AssertCustomerGroupNotInGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersAssertCustomerGroupNotInGrid
		$I->waitForPageLoad(30); // stepKey: cleanFiltersAssertCustomerGroupNotInGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageAssertCustomerGroupNotInGrid
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageAssertCustomerGroupNotInGridWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", $I->retrieveEntityField('customerGroup', 'code', 'test')); // stepKey: fillNameFieldOnFiltersSectionAssertCustomerGroupNotInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonAssertCustomerGroupNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonAssertCustomerGroupNotInGridWaitForPageLoad
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageAssertCustomerGroupNotInGrid
		$I->comment("Exiting Action Group [assertCustomerGroupNotInGrid] AssertCustomerGroupNotInGridActionGroup");
		$I->comment("Entering Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customer', 'id', 'test')); // stepKey: openCustomerEditPageOpenCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPage
		$I->comment("Exiting Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Entering Action Group [assertCustomerGroupOnCustomerForm] AssertCustomerGroupOnCustomerFormActionGroup");
		$I->click("#tab_customer"); // stepKey: clickOnAccountInfoTabAssertCustomerGroupOnCustomerForm
		$I->waitForPageLoad(30); // stepKey: clickOnAccountInfoTabAssertCustomerGroupOnCustomerFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertCustomerGroupOnCustomerForm
		$I->seeOptionIsSelected("[name='customer[group_id]']", "General"); // stepKey: verifyNeededCustomerGroupSelectedAssertCustomerGroupOnCustomerForm
		$I->comment("Exiting Action Group [assertCustomerGroupOnCustomerForm] AssertCustomerGroupOnCustomerFormActionGroup");
		$I->comment("Entering Action Group [openNewProductForm] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: openProductNewPageOpenNewProductForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenNewProductForm
		$I->comment("Exiting Action Group [openNewProductForm] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Entering Action Group [assertCustomerGroupNotOnProductForm] AssertCustomerGroupNotOnProductFormActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonAssertCustomerGroupNotOnProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonAssertCustomerGroupNotOnProductFormWaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonAssertCustomerGroupNotOnProductForm
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonAssertCustomerGroupNotOnProductFormWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAssertCustomerGroupNotOnProductForm
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAssertCustomerGroupNotOnProductFormWaitForPageLoad
		$customerGroupsAssertCustomerGroupNotOnProductForm = $I->grabMultiple("[name='product[tier_price][0][cust_group]'] option"); // stepKey: customerGroupsAssertCustomerGroupNotOnProductForm
		$I->assertNotContains($I->retrieveEntityField('customerGroup', 'code', 'test'), $customerGroupsAssertCustomerGroupNotOnProductForm); // stepKey: assertCustomerGroupNotInOptionsAssertCustomerGroupNotOnProductForm
		$I->comment("Exiting Action Group [assertCustomerGroupNotOnProductForm] AssertCustomerGroupNotOnProductFormActionGroup");
		$I->comment("Entering Action Group [openNewCatalogPriceRuleForm] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageOpenNewCatalogPriceRuleForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenNewCatalogPriceRuleForm
		$I->comment("Exiting Action Group [openNewCatalogPriceRuleForm] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [assertCustomerGroupNotOnCatalogPriceRuleForm] AssertCustomerGroupNotOnCatalogPriceRuleFormActionGroup");
		$customerGroupsAssertCustomerGroupNotOnCatalogPriceRuleForm = $I->grabMultiple("[name='customer_group_ids'] option"); // stepKey: customerGroupsAssertCustomerGroupNotOnCatalogPriceRuleForm
		$I->assertNotContains($I->retrieveEntityField('customerGroup', 'code', 'test'), $customerGroupsAssertCustomerGroupNotOnCatalogPriceRuleForm); // stepKey: assertCustomerGroupNotInOptionsAssertCustomerGroupNotOnCatalogPriceRuleForm
		$I->comment("Exiting Action Group [assertCustomerGroupNotOnCatalogPriceRuleForm] AssertCustomerGroupNotOnCatalogPriceRuleFormActionGroup");
		$I->comment("Entering Action Group [openNewCartPriceRuleForm] AdminOpenNewCartPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/new/"); // stepKey: openNewCartPriceRulePageOpenNewCartPriceRuleForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenNewCartPriceRuleForm
		$I->comment("Exiting Action Group [openNewCartPriceRuleForm] AdminOpenNewCartPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [assertCustomerGroupNotOnCartPriceRuleForm] AssertCustomerGroupNotOnCartPriceRuleFormActionGroup");
		$customerGroupsAssertCustomerGroupNotOnCartPriceRuleForm = $I->grabMultiple("select[name='customer_group_ids'] option"); // stepKey: customerGroupsAssertCustomerGroupNotOnCartPriceRuleForm
		$I->assertNotContains($I->retrieveEntityField('customerGroup', 'code', 'test'), $customerGroupsAssertCustomerGroupNotOnCartPriceRuleForm); // stepKey: assertCustomerGroupNotInOptionsAssertCustomerGroupNotOnCartPriceRuleForm
		$I->comment("Exiting Action Group [assertCustomerGroupNotOnCartPriceRuleForm] AssertCustomerGroupNotOnCartPriceRuleFormActionGroup");
	}
}
