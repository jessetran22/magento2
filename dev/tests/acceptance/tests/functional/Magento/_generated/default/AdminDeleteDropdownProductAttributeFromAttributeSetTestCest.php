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
 * @Title("MC-10885: Delete Product Attribute, Dropdown Type, from Attribute Set")
 * @Description("Login as admin and delete dropdown type product attribute from attribute set<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteDropdownProductAttributeFromAttributeSetTest.xml<br>")
 * @TestCaseId("MC-10885")
 * @group mtf_migrated
 */
class AdminDeleteDropdownProductAttributeFromAttributeSetTestCest
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
		$I->comment("Create Dropdown Product Attribute");
		$I->createEntity("attribute", "hook", "productDropDownAttribute", [], []); // stepKey: attribute
		$I->comment("Create Attribute set");
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Created Data");
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
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
	public function AdminDeleteDropdownProductAttributeFromAttributeSetTest(AcceptanceTester $I)
	{
		$I->comment("Open Product Attribute Set Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeSetPageToLoad
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickOnResetFilter
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterWaitForPageLoad
		$I->comment("Filter created Product Attribute Set");
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: fillAttributeSetName
		$I->click("#container button[title='Search']"); // stepKey: clickOnSearchButton
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->click("//td[contains(text(), '" . $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test') . "')]"); // stepKey: clickOnAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetEditPageToLoad
		$I->comment("Assign Attribute to the Group and save the attribute set");
		$I->comment("Entering Action Group [assignAttribute] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttribute
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttribute
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('attribute', 'attribute_code', 'test') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttribute
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttribute
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttribute
		$I->comment("Exiting Action Group [assignAttribute] AssignAttributeToGroupActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToSave
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessage
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
		$I->comment("Confirm Attribute is not present in Product Attribute Grid");
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
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: fillAttributeSetName1
		$I->click("#container button[title='Search']"); // stepKey: clickOnSearchButton1
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1
		$I->click("//td[contains(text(), '" . $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test') . "')]"); // stepKey: clickOnAttributeSet1
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetEditPageToLoad1
		$I->dontSee($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: dontSeeAttributeInAttributeGroupTree
		$I->dontSee($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div2"); // stepKey: dontSeeAttributeInUnassignedAttributeTree
	}
}
