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
 * @Title("MC-170: Admin should be able to create new group in an Attribute Set")
 * @Description("The test verifies creating a new group in an attribute set and a validation message in case of empty group name<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateNewGroupForAttributeSetTest.xml<br>")
 * @TestCaseId("MC-170")
 * @group Catalog
 */
class AdminCreateNewGroupForAttributeSetTestCest
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
		$I->comment("Create a custom attribute set and custom product attribute");
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->comment("Login to Admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
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
	 * @Stories({"Edit attribute set"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateNewGroupForAttributeSetTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to Stores > Attributes > Attribute Set");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Search and open Attribute Set from preconditions");
		$I->comment("Entering Action Group [searchAttribute] GoToAttributeSetByNameActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickResetButtonSearchAttribute
		$I->waitForPageLoad(30); // stepKey: clickResetButtonSearchAttributeWaitForPageLoad
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterByNameSearchAttribute
		$I->click("#container button[title='Search']"); // stepKey: clickSearchSearchAttribute
		$I->waitForPageLoad(30); // stepKey: clickSearchSearchAttributeWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowSearchAttribute
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchAttribute
		$I->comment("Exiting Action Group [searchAttribute] GoToAttributeSetByNameActionGroup");
		$I->comment("Click 'Add New': Show 'New Group' Modal");
		$I->click("button[data-ui-id='adminhtml-catalog-product-set-edit-add-group-button']"); // stepKey: clickAddNew
		$I->waitForAjaxLoad(30); // stepKey: waitForAjax
		$I->comment("Fill 'name' for new group and click 'Ok': Name = <empty>");
		$I->fillField("input[data-role='promptField']", ""); // stepKey: fillName
		$I->click(".modal-footer .action-primary.action-accept"); // stepKey: clickOk
		$I->comment("Error message 'This is a required field.' is displayed");
		$I->see("This is a required field.", "label.mage-error"); // stepKey: seeErrorMessage
		$I->comment("Fill 'name' for new group and click 'Ok': Name = Custom group");
		$I->fillField("input[data-role='promptField']", "Custom Group"); // stepKey: fillCustomGroupName
		$I->click(".modal-footer .action-primary.action-accept"); // stepKey: clickButtonOk
		$I->comment("Group is created and displayed in 'Groups' block");
		$I->seeElement("//*[@id='tree-div1']//span[text()='Custom Group']"); // stepKey: assertCustomGroup
		$I->comment("Move custom Product Attribute to new 'Custom group' Group");
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoad
		$I->click("//*[@id='tree-div1']//span[text()='Custom Group']"); // stepKey: click
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClick
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test') . "']", "//*[@id='tree-div1']//span[text()='Custom Group']"); // stepKey: moveAttribute
		$I->waitForPageLoad(30); // stepKey: waitForDragAndDrop
		$I->comment("Attribute is displayed in the new group");
		$I->see($I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttribute
		$I->comment("Click 'Save'");
		$I->comment("Entering Action Group [saveAttribute] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttribute
		$I->comment("Exiting Action Group [saveAttribute] SaveAttributeSetActionGroup");
		$I->comment("Entering Action Group [backTohAttributeSet] GoToAttributeSetByNameActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickResetButtonBackTohAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickResetButtonBackTohAttributeSetWaitForPageLoad
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterByNameBackTohAttributeSet
		$I->click("#container button[title='Search']"); // stepKey: clickSearchBackTohAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSearchBackTohAttributeSetWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowBackTohAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadBackTohAttributeSet
		$I->comment("Exiting Action Group [backTohAttributeSet] GoToAttributeSetByNameActionGroup");
		$I->comment("Create another group: Name = Empty group");
		$I->click("button[data-ui-id='adminhtml-catalog-product-set-edit-add-group-button']"); // stepKey: clickAddEmptyGroup
		$I->waitForAjaxLoad(30); // stepKey: waitForLoad
		$I->fillField("input[data-role='promptField']", "Empty Group"); // stepKey: fillGroupName
		$I->click(".modal-footer .action-primary.action-accept"); // stepKey: clickOnOk
		$I->waitForPageLoad(30); // stepKey: waitForNewGroup
		$I->comment("Empty group is created. No attributes are assigned to it.");
		$I->seeElement("//*[@id='tree-div1']//span[text()='Empty Group']"); // stepKey: assertEmptyGroup
		$I->dontSeeElement("//span[text()='Empty Group']/../../following-sibling::ul/li"); // stepKey: seeNoAttributes
		$I->comment("Navigate to Catalog > Products");
		$I->comment("Entering Action Group [amOnProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductPage
		$I->comment("Exiting Action Group [amOnProductPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Start to create a new simple product with the custom attribute set from the preconditions");
		$I->click("#add_new_product-button"); // stepKey: clickAddProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForNewProductPage
		$I->comment("Entering Action Group [selectAttribute] AdminProductPageSelectAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: openDropdownSelectAttribute
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterSelectAttribute
		$I->waitForPageLoad(30); // stepKey: filterSelectAttributeWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: clickResultSelectAttribute
		$I->waitForPageLoad(30); // stepKey: clickResultSelectAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [selectAttribute] AdminProductPageSelectAttributeSetActionGroup");
		$I->comment("New Section 'Custom group' is present in form. The section contains the attribute from preconditions");
		$I->seeElement("//div[@class='fieldset-wrapper-title']//span[text()='Custom Group']"); // stepKey: seeSectionCustomGroup
		$I->click("//div[@class='fieldset-wrapper-title']//span[text()='Custom Group']"); // stepKey: openCustomGroupSection
		$I->waitForAjaxLoad(30); // stepKey: waitForOpenSection
		$I->scrollTo("//footer"); // stepKey: scrollToFooter
		$I->seeElement("//div[@class='fieldset-wrapper-title']//span[text()='Custom Group']/../../following-sibling::div//span[contains(text(),'attribute')]"); // stepKey: seeAttributePresent
		$I->comment("Empty section is absent in Product Form");
		$I->dontSeeElement("//div[@class='fieldset-wrapper-title']//span[text()='Empty Group']"); // stepKey: dontSeeEmptyGroup
	}
}
