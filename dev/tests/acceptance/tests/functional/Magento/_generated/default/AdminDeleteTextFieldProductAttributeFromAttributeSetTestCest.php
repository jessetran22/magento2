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
 * @Title("MC-10886: Delete Product Attribute, Text Field, from Attribute Set")
 * @Description("Login as admin and delete Text Field type product attribute from attribute set<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteTextFieldProductAttributeFromAttributeSetTest.xml<br>")
 * @TestCaseId("MC-10886")
 * @group mtf_migrated
 */
class AdminDeleteTextFieldProductAttributeFromAttributeSetTestCest
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
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create Product Attribute and assign to Default Product Attribute Set");
		$I->createEntity("attribute", "hook", "newProductAttribute", [], []); // stepKey: attribute
		$I->createEntity("addToDefaultAttributeSet", "hook", "AddToDefaultSet", ["attribute"], []); // stepKey: addToDefaultAttributeSet
		$I->comment("Create Simple Product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete cteated Data");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimplaeProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Delete product attributes"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteTextFieldProductAttributeFromAttributeSetTest(AcceptanceTester $I)
	{
		$I->comment("Open Product Attribute Set Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeSetPageToLoad
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickOnResetFilter
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterWaitForPageLoad
		$I->comment("Select Default Product Attribute Set");
		$I->fillField("#setGrid_filter_set_name", "Default"); // stepKey: fillAttributeSetName
		$I->click("#container button[title='Search']"); // stepKey: clickOnSearchButton
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetEditPageToLoad
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInAttributeGroupTree
		$I->comment("Open Product Index Page and filter the product");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProduct2" . msq("SimpleProduct2")); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Verify Created Product Attribute displayed in Product page");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad
		$I->seeElement("//fieldset[@class='admin__fieldset']//div[contains(@data-index,'" . $I->retrieveEntityField('attribute', 'attribute_code', 'test') . "')]"); // stepKey: seeProductAttributeIsAdded
		$I->comment("Delete product attribute from product attribute grid");
		$I->comment("Entering Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenProductAttributeFromSearchResultInGrid
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('attribute', 'attribute_code', 'test')); // stepKey: setAttributeCodeOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenProductAttributeFromSearchResultInGrid
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('attribute', 'attribute_code', 'test') . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenProductAttributeFromSearchResultInGrid
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('attribute', 'attribute_code', 'test') . "')]"); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenProductAttributeFromSearchResultInGrid
		$I->comment("Exiting Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadDeleteProductAttributeByAttributeCode
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewProductAttributePageLoadDeleteProductAttributeByAttributeCode
		$I->comment("Exiting Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductAttributeSuccess
		$I->comment("Exiting Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->comment("Confirm attribute is not present in product attribute grid");
		$I->comment("Entering Action Group [filterAttribute] FilterProductAttributeByAttributeCodeActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridFilterAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridFilterAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('attribute', 'attribute_code', 'test')); // stepKey: setAttributeCodeFilterAttribute
		$I->waitForPageLoad(30); // stepKey: waitForUserInputFilterAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridFilterAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridFilterAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [filterAttribute] FilterProductAttributeByAttributeCodeActionGroup");
		$I->see("We couldn't find any records.", "//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: seeEmptyRow
		$I->waitForPageLoad(30); // stepKey: seeEmptyRowWaitForPageLoad
		$I->comment("Verify Attribute is not present in Product Attribute Set Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets1
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeSetPageToLoad1
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickOnResetFilter1
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilter1WaitForPageLoad
		$I->fillField("#setGrid_filter_set_name", "Default"); // stepKey: fillAttributeSetName1
		$I->click("#container button[title='Search']"); // stepKey: clickOnSearchButton1
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow1
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetEditPageToLoad1
		$I->dontSee($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: dontSeeAttributeInAttributeGroupTree
		$I->dontSee($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div2"); // stepKey: dontSeeAttributeInUnassignedAttributeTree
		$I->comment("Verify Product Attribute is not present in Product Index Page");
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProduct1] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct1
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProduct2" . msq("SimpleProduct2")); // stepKey: fillProductSkuFilterFilterProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProduct1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct1
		$I->comment("Exiting Action Group [filterProduct1] FilterProductGridBySkuActionGroup");
		$I->comment("Verify Product Attribute is not present in Product page");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoad
		$I->dontSeeElement("//fieldset[@class='admin__fieldset']//div[contains(@data-index,'" . $I->retrieveEntityField('attribute', 'attribute_code', 'test') . "')]"); // stepKey: dontSeeProductAttribute
	}
}
