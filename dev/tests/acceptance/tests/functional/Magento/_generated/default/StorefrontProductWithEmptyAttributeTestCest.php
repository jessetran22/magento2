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
 * @Title("MAGETWO-91893: Product attribute is not visible on storefront if it is empty")
 * @Description("Product attribute should not be visible on storefront if it is empty<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontProductWithEmptyAttributeTest.xml<br>")
 * @TestCaseId("MAGETWO-91893")
 * @group product
 */
class StorefrontProductWithEmptyAttributeTestCest
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
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("createProductAttribute", "hook", "productAttributeWithDropdownTwoOptions", [], []); // stepKey: createProductAttribute
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteSimpleProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteSimpleProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteSimpleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillProductSkuFilterDeleteSimpleProduct
		$I->fillField("input.admin__control-text[name='name']", "Simple Product " . msq("SimpleProduct")); // stepKey: fillProductNameFilterDeleteSimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSimpleProductWaitForPageLoad
		$I->see("SimpleProduct" . msq("SimpleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSimpleProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSimpleProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSimpleProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSimpleProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSimpleProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteSimpleProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteSimpleProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSimpleProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"Catalog"})
	 * @Stories({"Create products"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductWithEmptyAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: amOnAttributeSetPage
		$I->click("//td[contains(text(), 'Default')]"); // stepKey: chooseDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoad
		$I->dragAndDrop("//span[text()='testattribute']", "//span[text()='Product Details']"); // stepKey: moveProductAttributeToGroup
		$I->click("button[title='Save']"); // stepKey: saveAttributeSet
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear
		$I->seeElement(".message-success"); // stepKey: assertSuccess
		$I->comment("Entering Action Group [fillProductFieldsInAdmin] FillAdminSimpleProductFormActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFillProductFieldsInAdmin
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownFillProductFieldsInAdminWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddSimpleProductFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: clickAddSimpleProductFillProductFieldsInAdminWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "Simple Product " . msq("SimpleProduct")); // stepKey: fillNameFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=sku] input", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillSKUFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=qty] input", "1000"); // stepKey: fillQuantityFillProductFieldsInAdmin
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityFillProductFieldsInAdmin
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createPreReqCategory', 'name', 'test')]); // stepKey: searchAndSelectCategoryFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryFillProductFieldsInAdminWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: openSeoSectionFillProductFieldsInAdminWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "simple-product-" . msq("SimpleProduct")); // stepKey: fillUrlKeyFillProductFieldsInAdmin
		$I->click("#save-button"); // stepKey: saveProductFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: saveProductFillProductFieldsInAdminWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=name] input", "Simple Product " . msq("SimpleProduct")); // stepKey: assertFieldNameFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=sku] input", "SimpleProduct" . msq("SimpleProduct")); // stepKey: assertFieldSkuFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=price] input", "123.00"); // stepKey: assertFieldPriceFillProductFieldsInAdmin
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionAssertFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: openSeoSectionAssertFillProductFieldsInAdminWaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "simple-product-" . msq("SimpleProduct")); // stepKey: assertFieldUrlKeyFillProductFieldsInAdmin
		$I->comment("Exiting Action Group [fillProductFieldsInAdmin] FillAdminSimpleProductFormActionGroup");
		$I->comment("Entering Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCache
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCache
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCache
		$I->comment("Exiting Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage("/simple-product-" . msq("SimpleProduct") . ".html"); // stepKey: goProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoad
		$I->dontSeeElement("//table[@id='product-attribute-specs-table']/tbody/tr/th[contains(text(),'testattribute')]"); // stepKey: seeAttribute2
	}
}
