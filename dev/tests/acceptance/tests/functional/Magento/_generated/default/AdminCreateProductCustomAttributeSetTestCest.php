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
 * @Title("MC-244: Admin should be able to create a simple product using a custom attribute set")
 * @Description("Admin should be able to create a simple product using a custom attribute set<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateProductCustomAttributeSetTest.xml<br>")
 * @TestCaseId("MC-244")
 * @group Catalog
 */
class AdminCreateProductCustomAttributeSetTestCest
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
		$I->comment("Delete the new attribute set");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets
		$I->waitForPageLoad(30); // stepKey: wait1
		$I->fillField("#setGrid_filter_set_name", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: filterByName
		$I->click("#container button[title='Search']"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->click("button[title='Delete']"); // stepKey: clickDelete
		$I->waitForPageLoad(30); // stepKey: clickDeleteWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDelete
		$I->waitForPageLoad(30); // stepKey: confirmDeleteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: wait3
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPage
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
	 * @Stories({"Add/Update attribute set"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateProductCustomAttributeSetTest(AcceptanceTester $I)
	{
		$I->comment("Create a new attribute set");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets
		$I->waitForPageLoad(30); // stepKey: wait1
		$I->click("button.add-set"); // stepKey: clickAddAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeSetWaitForPageLoad
		$I->fillField("#attribute_set_name", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillName
		$I->selectOption("#skeleton_set", "Default"); // stepKey: selectDefaultSet
		$I->click("button.save-attribute-set"); // stepKey: clickSave1
		$I->waitForPageLoad(30); // stepKey: clickSave1WaitForPageLoad
		$I->dragAndDrop("//span[text()='meta_keyword']", "//span[text()='manufacturer']"); // stepKey: unassign1
		$I->click("button.add"); // stepKey: clickAddNewGroup
		$I->waitForPageLoad(30); // stepKey: clickAddNewGroupWaitForPageLoad
		$I->fillField("input[name='name']", "TestGroupName"); // stepKey: fillNewGroupName
		$I->click("button.action-accept"); // stepKey: clickOkInModal
		$I->waitForPageLoad(30); // stepKey: clickOkInModalWaitForPageLoad
		$I->dragAndDrop("//span[text()='manufacturer']", "//span[text()='TestGroupName']"); // stepKey: assignManufacturer
		$I->click("button.save-attribute-set"); // stepKey: clickSave2
		$I->waitForPageLoad(30); // stepKey: clickSave2WaitForPageLoad
		$I->comment("Go to new product page and see a default attribute");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: goToNewProductPage
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: expandSEOSection
		$I->waitForPageLoad(30); // stepKey: expandSEOSectionWaitForPageLoad
		$I->seeElementInDOM("div[data-index='meta_keyword']"); // stepKey: seeMetaKeyword
		$I->dontSeeElementInDOM("div[data-index='testgroupname']"); // stepKey: dontSeeTestGroupName
		$I->comment("Switch from default attribute set to new attribute set");
		$I->comment("A scrollToTopOfPage is needed to hide the floating header");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->comment("Entering Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: clickAttributeSetDropdownStartEditAttrSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: searchForAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: searchForAttributeSetStartEditAttrSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: selectAttributeSetStartEditAttrSetWaitForPageLoad
		$I->comment("Exiting Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("See new attibute set");
		$I->seeElementInDOM("div[data-index='testgroupname']"); // stepKey: seeTestGroupName
		$I->dontSeeElementInDOM("div[data-index='meta_keyword']"); // stepKey: dontSeeMetaKeyword
		$I->comment("Finish filling the new product page");
		$I->comment("Entering Action Group [fillSimpleProductMain] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillSimpleProductMain
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillSimpleProductMain
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillSimpleProductMain
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillSimpleProductMain
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillSimpleProductMain
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillSimpleProductMainWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillSimpleProductMain
		$I->comment("Exiting Action Group [fillSimpleProductMain] FillMainProductFormNoWeightActionGroup");
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Check the storefront");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: seeProductNameInTitlte
		$I->see("testProductName" . msq("_defaultProduct"), ".base"); // stepKey: assertProductName
		$I->see("testSku" . msq("_defaultProduct"), ".product.attribute.sku>.value"); // stepKey: assertProductSku
		$I->see("$123.00", "div.price-box.price-final_price"); // stepKey: assertProductPrice
	}
}
